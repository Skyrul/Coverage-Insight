<?php 

abstract class CardProviderFacade
{
    public static function lists()
    {
        return array(
            'Visa'=>'Visa', 
            'MasterCard'=>'MasterCard',
            'American Express'=>'American Express',
            'Discover'=>'Discover',
        );
    }

    public static function date_months()
    {
        $results = array();
        for($i=1;$i<=12;$i++) {
            $m = date('F', mktime(0, 0, 0, $i, 10));
            $results[$i] = $m;
        }
        return $results;
    }
    
    public static function date_years()
    {
        $results = array();
        for($i=date('Y');$i<=date('Y')+12;$i++) {
            $results[$i] = $i;
        }
        return $results;
    }
    
}

?>