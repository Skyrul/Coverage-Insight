<?php
$to = "jim.campbell@engagex.com";
// $to = "joven.barola@engagex.com";
$subject = "[Coverage Insight - Bitbucket Version Control Push] ";
$json = file_get_contents('php://input');
if (empty($json)) {
    exit;
}
$body = json_to_table($json);

$txt = "Engagex Developer Pushed Update to Bitbucket Source Repository\n\nDetails: \n\n".$body;
$headers = "From: joven.barola@engagex.com" . "\r\n" .
    "CC: joven.barola@engagex.com";

mail($to,$subject,$txt,$headers);



function json_to_table($body){
    $arr = json_decode($body, true);

    $result = '';
    
    foreach($arr as $k=>$v) {
        if($k == 'push') {
            foreach($v['changes'][0]['new']['target'] as $kk=>$vv) {
                if ($kk == 'message' || $kk == 'date' || $kk == 'hash') {
                    $result .=  $kk.": ". $vv . "\n";
                }
            }
        }
        
        if($k == 'repository') {
            foreach($v['owner'] as $kk=>$vv) {
                if ($kk == 'username' || $kk == 'display_name' || $kk == 'uuid') {
                    $result .=  $kk.": ". $vv . "\n";
                }
            }
        }
        
    }
    $result .= "https://bitbucket.org/jovenbarola/agencythrive_tool\n";
    
    return $result;
}
?>