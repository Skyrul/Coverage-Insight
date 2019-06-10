<?php
class AccountFacade {
    
    public static function is_access_expired()
    {
        // $model = LockAccount::model()->find('account_id = :account_id', array(
        //     ':account_id'=>Yii::app()->session['account_id']
        // ));
        // if ($model != null) {
        //     $current_date = date('Y-m-d');
        //     $locked_date = date('Y-m-d', strtotime($model->locked_date));
        //     $date1 = new DateTime($current_date);
        //     $date2 = new DateTime($locked_date);
        //     $days  = $date2->diff($date1)->format('%R%a');
        //     $days  = floatval($days);

        //     if($days >= 0) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        // Check if theres UNPAID invoice on this month
        $model = Billing::model()->find("account_id = :account_id AND bill_status = 'UNPAID';", array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        if ($model != null) {
            return true;
        }

        return false;
    }
    
    public static function is_account_cancelled()
    {
        $model = CancelledAccount::model()->find('account_id = :account_id', array(
            ':account_id'=>Yii::app()->session['account_id']
        ));
        if ($model != null) {
            return true;
        }
        return false;
    }
}