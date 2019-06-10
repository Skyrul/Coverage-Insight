<?php
$to = "jim.campbell@engagex.com";
// $to = "joven.barola@engagex.com";
$subject = "[Coverage Insight - GitHub Version Control Push] ";
$json = file_get_contents('php://input');
if (empty($json)) {
    exit;
}
$body = json_to_table($json);
// [DEBUG]
echo $body;

$txt = "Engagex Developer Pushed Update to Github Source Repository\n\nDetails: \n\n".$body;
$headers = "From: joven.barola@engagex.com" . "\r\n" .
    "CC: joven.barola@engagex.com";

mail($to,$subject,$txt,$headers);



function json_to_table($body){
    $arr = json_decode($body, true);
    $result  = 'Pushed by: ' . $arr['pusher']['name'] . "\n";
    $result .= 'Message: ' . $arr['head_commit']['message'] . "\n";
    $result .= 'Timestamp: ' . $arr['head_commit']['timestamp'] . "\n";
    $result .= "https://github.com/EngagexCorpDev/Coverage-Insight\n";
    
    return $result;
}
?>