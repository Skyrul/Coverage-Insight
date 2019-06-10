<?php
/**
 * @author Joven
 **/

abstract class StaffFacade 
{    
    
    public static function getTotalCredits()
    {
        $credits = 0;
        $staffcredits = StaffCredits::model()->findAll('account_id=:id', array(':id'=>Yii::app()->session['account_id']));
        foreach($staffcredits as $k=>$v){
            $credits += (int)$v->staff_credit;
        }
        
        return $credits;
    }
    
    public static function getStaffCount()
    {
        return $cnt = (int)Staff::model()->count('account_id=:account_id AND roles=:roles', array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':roles'=>EnumRoles::STAFF,
        ));
    }
    
    public static function getRemainingCredits()
    {
        $credits  = $remaining = 0;
        $credits  = self::getTotalCredits();
        $staffcnt = self::getStaffCount();
        return $remaining = $credits - $staffcnt;
    }
    
}

