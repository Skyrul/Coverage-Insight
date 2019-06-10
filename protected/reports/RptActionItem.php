<?php
/**
 * Description of RptActionItem
 *
 * @author Joven
 */
class RptActionItem {

    public static function Content() 
    {
        $head = '';
        $body = '';
        $foot = '';
        
        // head
        $head .= '<h1>Action Item</h1>';
        $head .= '<p>&nbsp;</p>';

        // body
        $criteria = new CDbCriteria;
        $criteria->condition = "account_id = :account_id";
        $criteria->params = array(
            ':account_id'=>Yii::app()->session['account_id'],
        );
        $records = ActionItem::model()->findAll($criteria);
        if (!empty($records)) {
            $body .= '<table border="1" cellpadding="2">';
            $body .= '<tr class="trhead">';
            $body .= '<td style="width:50px;text-align:center;">Cmpltd</td>';
            $body .= '<td>Primary</td>';
            $body .= '<td>Secondary</td>';
            $body .= '<td>Owner</td>';
            $body .= '<td style="width:45px;text-align:center;">Opt</td>';
            $body .= '<td style="width:150px;text-align:left;">Description</td>';
            $body .= '<td>Creation Date</td>';
            $body .= '<td>Due Date</td>';
            $body .= '</tr>';
            foreach($records as $k => $v) {
                $primary_fname = '';
                $secondary_fname = '';
                $completed =($v->is_completed == 1) ? '<img src="/images/check.png" class="checkbox">' : '';
                $opportunity = ($v->is_opportunity == 1) ? '<img src="/images/check.png" class="checkbox">' : '';
                $due_date = date('m/d/Y', strtotime($v->due_date));
                $due_date = ($due_date == '01/01/1970') ? '' : $due_date;
                $criteria->condition = "id = :customer_id";
                $criteria->params = array(
                    ':customer_id'=>$v->customer_id,
                );
                $model = Customer::model()->find($criteria);
                if ($model!=null) {
                    $primary_fname = $model->primary_firstname . ' ' . $model->primary_lastname;
                    $secondary_fname = $model->secondary_firstname . ' ' . $model->secondary_lastname;
                }
                $body .= '<tr style="font-size: 10px;padding:2px;">';
                $body .= '<td style="text-align:center;">'. $completed .'</td>';
                $body .= '<td>'. $primary_fname .'</td>';
                $body .= '<td>'. $secondary_fname .'</td>';
                $body .= '<td>'. $v->owner .'</td>';
                $body .= '<td style="text-align:center;">'. $opportunity .'</td>';
                $body .= '<td>'. $v->description .'</td>';
                $body .= '<td>'. date('m/d/Y', strtotime($v->created_date)) .'</td>';
                $body .= '<td>'. $due_date .'</td>';
                $body .= '</tr>';
            }
            $body .= '</table>';   
        }
        
        return array(
            'head'=> $head,
            'body'=> $body,
            'foot'=> $foot,
            'logo_pos'=>'R'
        );
    }
}
