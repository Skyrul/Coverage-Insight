<?php
/**
 * Description of RptSOA
 *
 * @author Joven
 */
class RptSOA {

    public static function Content($param) 
    {
        $criteria = new CDbCriteria;
        $head = '';
        $body = '';
        $foot = '';
        
        $criteria->condition = "bill_no = :billno";
        $criteria->params = array(
            ':billno'=>$_GET['billno'],
        );
        $soa = Billing::model()->find($criteria);
        if ($soa != null) {
            $acct_setup = AccountSetup::model()->find('id=:account_id', array(
                ':account_id'=>$soa->account_id,
            ));
            
            if ($soa->bill_status == EnumStatus::UNPAID) {
                $status_color = 'red';
            }
            else if ($soa->bill_status == EnumStatus::PAID) {
                $status_color = 'blue';
            }
            
            
            // head
            $head .= '<br><br>';
            $head .= '<table style="width:100%;">';
            $head .= '<tr>';
            $head .= ' <td><h1 style="text-align:left;"><strong>INVOICE</strong> #'. $soa->bill_no .'</h1></td>';
            $head .= ' <td><h1 style="text-align:right;color:'.$status_color.'">'. $soa->bill_status .'</h1></td>';
            $head .= '</tr>';
            $head .= '<tr>';
            $head .= ' <td><strong>Invoice Date:</strong> '. date('m/d/Y', strtotime($soa->created_at)) .'</td>';
            $head .= ' <td></td>';
            $head .= '</tr>';
            $head .= '<tr>';
            $head .= ' <td><strong>Email:</strong> '. $acct_setup->email .'</td>';
            $head .= '</tr>';
            $head .= '</table>';
            $head .= '<br><br>';
            
            
            /* body */            
            $body .= '<table cellpadding="4" border="1">';
            $body .= '<tr class="trhead" style="font-weight:bold;">';
            $body .= ' <td style="width: 60%">Description</td>';
            $body .= ' <td style="width: 10%;text-align:center;">Quantity</td>';
            $body .= ' <td style="width: 30%;text-align:right;">Total</td>';
            $body .= '</tr>';
            
            
            $body .= '<tr>';
            $body .= ' <td>'. $soa->bill_type .'</td>';
            $body .= ' <td class="text-center">1</td>';
            $body .= ' <td class="text-right">$'. number_format($soa->fee, 2) .'</td>';
            $body .= '</tr>';
            
            // get initial bill amount
            $total_billamount = $soa->bill_amount;

            $promo_code = '';
            $promo_off = 0;
            if ($soa->promo_off > 0){
                $promo_code = $soa->promo_code;
                $promo_off  = $soa->promo_off;
                $body .= '<tr>'; 
                $body .= ' <td>PROMO (Code:'. $promo_code .' / Amount Off: $'. $promo_off .')</td>';
                $body .= ' <td class="text-right"></td>';
                $body .= ' <td class="text-right">-'. number_format($promo_off, 2) .'</td>';
                $body .= '</tr>';
            }

            // gift cards orders
            $gc_total = BillingFacade::giftcard_order_total();
            $gc_qty = BillingFacade::giftcard_order_qty();
            if ($gc_total > 0) {
                $body .= '<tr>'; 
                $body .= ' <td>Virtual Incentives - Gift Cards Orders</td>';
                $body .= ' <td class="text-center">'. $gc_qty .'</td>';
                $body .= ' <td class="text-right">'. number_format($gc_total, 2) .'</td>';
                $body .= '</tr>';

                $total_billamount += $gc_total;
            }

            $body .= '<tr>';
            $body .= ' <td colspan="100">&nbsp;</td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td colspan="100">';
            $body .= '   <div style="text-align:right;font-size: 16px;"><strong>Total (in USD):</strong> $'. number_format($total_billamount, 2) .'</div>';
            $body .= ' </td>';
            $body .= '</tr>';
            
            $body .= '</table>';
            $body .= '<br><br>';
            
            
            $body .= '<div class="boxgray text-center">Please Pay By: '. date('m/d/Y', strtotime($soa->due_date)) .'</div><br>';
            
            
            $body .= '<table style="width:100%;">';
            $body .= '<tr valign="top">';
            
            // payment to
            $body .= '<td>';
            $body .= '<div style="text-align:left;">';
            $body .= '<strong style="font-size:14px;">Please send payment to:</strong><br>';
            $body .= Yii::app()->params['company_name'] . '<br>';
            $body .= Yii::app()->params['company_address'] . '<br>';
            $body .= '</div>';
            $body .= '</td>';
            
            // bill to
            $body .= '<td>';
            $body .= '<div style="text-align:left;">';
            $body .= '<strong style="font-size:14px;">Bill to:</strong><br>';
            $body .= $acct_setup->first_name . ' ' . $acct_setup->last_name . '<br>';
            $body .= $acct_setup->office_phone_number . '<br>';
            $body .= '</div>';
            $body .= '</td>';
            
            $body .= '</tr>';
            $body .= '</table><br><br>';
            
            $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
            $login_url =  $protocol . '://' .$_SERVER['SERVER_NAME'] . '/account/setup#billing';
            $body .= '<span>To make a payment, view your billing history, or ask questions about your account, please login to <a href="'. $login_url .'">'. $login_url .'</a>.</span>';
            

            
        }

        
        
        return array(
            'head'=> $head,
            'body'=> $body,
            'foot'=> $foot,
            'logo_pos'=> 'C'
        );
    }
}
