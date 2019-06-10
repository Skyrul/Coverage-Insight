<?php
/**
 * @author Joven
 **/

abstract class BillingFacade 
{    
    public static function invoices()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'account_id = :account_id';
        $criteria->params    = array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $criteria->order     = 'bill_status DESC';
        
        $results = array();
        $invoices = Billing::model()->findAll($criteria); 
        if (!empty($invoices)) {
            foreach ($invoices as $k=>$v){
                $txt = '#'. $v->bill_no . ' | ' . ' '. $v->bill_status .'';
                $results[$v->bill_no] = $txt;
            }
        }
        return $results;
    }
    
    public static function next_billing()
    {
        $criteria = new CDbCriteria();
        // $criteria->condition = 'account_id = :account_id AND bill_status = :bill_status';
        // $criteria->params=array(
        //     ':account_id'=>Yii::app()->session['account_id'],
        //     ':bill_status'=>EnumStatus::UNPAID,
        // );
        $criteria->condition = 'account_id = :account_id';
        $criteria->params=array(
            ':account_id'=>Yii::app()->session['account_id']
        );
        $criteria->order='id DESC'; // get last transaction
        $invoices = Billing::model()->find($criteria);
        if($invoices != null) {
            if ($invoices->next_billing == null) {
                $m = (int)date('m') + 1;
                $next_billing = date('m/d/Y', strtotime($invoices->created_at));
            } else {
                $m = (int)date('m', strtotime($invoices->next_billing));
                $next_billing = date('m/d/Y', strtotime($invoices->next_billing));
            }

            $next_billing = $m  . '/' . date('d', strtotime($next_billing)) . '/' . date('Y', strtotime($next_billing));

            if ($invoices->next_billing == null) {
                // update next_billing column
                $invoices->next_billing = date('Y-m-d', strtotime($next_billing));
                $invoices->update();
            }

            return date('m/d/Y', strtotime($next_billing));
        } else {
            return '';
        }


    }

    public static function giftcard_orders()
    {
        // only get orders that unpaid (means blank)
        $model = ReferralGC::model()->findAll("account_id=:account_id AND status = ''", array(
            ':account_id'=>Yii::app()->session['account_id'],
        ));
        return $model;
    }

    public static function giftcard_order_total()
    {
        $total_amount = 0;
        $model = self::giftcard_orders();
        if (!empty($model)) {
            foreach($model as $k => $v) {
                $total_amount += $v->gc_amount;
            }
        }
        return $total_amount;
    }

    public static function giftcard_order_qty()
    {
        $total = 0;
        $model = self::giftcard_orders();
        if (!empty($model)) {
            foreach($model as $k => $v) {
                $total = $total + 1;
            }
        }
        return $total;
    }

    public static function giftcard_orders_html()
    {
        $gc_order = self::giftcard_orders(); 
        if (!empty($gc_order)) {	
            echo '<table class="table table-bordered table-hover">';
            echo '<tr style="background-color:#ffc107;font-weight:bold;">';
            echo '<td>Recipient</td>';
            echo '<td>Date</td>';
            echo '<td>Type</td>';
            echo '<td>Amount</td>';
            echo '</tr>';
            foreach($gc_order as $k => $v) {
                echo '<tr>';
                echo '<td>'. $v->refer_email .'</td>';
                echo '<td>'. date('m/d/Y', strtotime($v->refer_date)) .'</td>';
                echo '<td>'. $v->gc_offer .'</td>';
                echo '<td class="text-right">'. $v->gc_amount .'</td>';
                echo '</tr>';
            }
            echo '<tr style="background-color:#f5f5f56b;">';
            echo '<td colspan="3" class="text-right">';
            echo 'Total (in USD):<br>';
            echo '<span style="color:red;font-size:9px;">Click <strong>"Process Card"</strong> to place order in Virtual-Incentives, and payment in Auth.net </span>';
            echo '</td>';
            echo '<td>';
            echo '<div class="text-right">'. self::giftcard_order_total() . '</div>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
        }
    }

    public function giftcard_create_order($detail)
    {
        $gc_order = self::giftcard_orders(); 
        if (!empty($gc_order)) {
            foreach($gc_order as $k => $v) {
                $ch = curl_init();
				$payload = '{
					 "order": {
					  "programid":"'. $detail['programid'] .'",
					  "clientid":"'. $detail['clientid'] .'",
					  "accounts":[
					   {
					   "firstname":"'. $detail['firstname'] .'",
					   "lastname":"'. $detail['lastname'] .'",
					   "email":"'. $detail['email'] .'",
					   "sku":"'. $detail['sku'] .'",
					   "amount":"'. $detail['amount'] .'"
					   }
					  ]
					 }
				}';
				$endpoint = "https://rest.virtualincentives.com/v4/json/orders";
				curl_setopt($ch, CURLOPT_URL,$endpoint);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Authorization
                $uid = $detail['uid'];
                $pwd = $detail['pwd'];
                $uid_pwd = base64_encode($uid . ':' . $pwd);
                $headers = [
                    'Content-Type: application/json',
                    'Authorization: Basic '. $uid_pwd,
                    'Host: rest.virtualincentives.com'
                ];
                
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);

                // response json
                echo json_encode($server_output);
            }
        }
    }
    
}

