<?php
/**
 * Description of RptCIR
 *
 * @author Joven
 */
class RptCIR {

    public static function Content($param) 
    {
        $criteria = new CDbCriteria;
        $head = '';
        $body = '';
        $foot = '';
        
        $criteria->condition = "account_id = :account_id AND id = :customer_id";
        $criteria->params = array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
        );
        $customer = Customer::model()->find($criteria);
        if ($customer != null) {
            $p_fname = $customer->primary_firstname . ' ' . $customer->primary_lastname;
            $s_fname = $customer->secondary_firstname . ' ' . $customer->secondary_lastname;
            
            // head
            $head .= '<br>';
            $head .= '<hr>';
            $head .= '<h3 class="title" style="text-align:center;">'
                    //. '<p style="position:absolute;width:200px;background-color:white;font-size:8px;text-align:right;">'. date('m/d/Y') .'</p>'
                    . 'Customer Insurance Review ('. $p_fname .' & '. $s_fname .')'
                    . '</h3>';
            $head .= '<hr>';
            $head .= '<br>';
            
            
            /* body */
           
            // Customer Information
            $body .= '<h3>Contact Information</h3>';
            $body .= '<table>';
            
            $body .= '<tr>';
            $body .= ' <td>Primary First Name:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_firstname .'</p></td>';
            $body .= ' <td>Secondary First Name:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_firstname .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Primary Last Name:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_lastname .'</p></td>';
            $body .= ' <td>Secondary Last Name:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_lastname .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Home Phone Number:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_telno .'</p></td>';
            $body .= ' <td>Home Phone Number:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_telno .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Cell Phone Number:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_cellphone .'</p></td>';
            $body .= ' <td>Cell Phone Number:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_cellphone .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Alt Phone Number:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_alt_telno .'</p></td>';
            $body .= ' <td>Alt Phone Number:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_alt_telno .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Home Address:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_address .'</p></td>';
            $body .= ' <td>Home Address:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_address .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Email Address:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_email .'</p></td>';
            $body .= ' <td>Email Address:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_email .'</p></td>';
            $body .= '</tr>';
            
            $body .= '<tr>';
            $body .= ' <td>Emergency Contact:</td>';
            $body .= ' <td><p class="text">'. $customer->primary_emergency_contact .'</p></td>';
            $body .= ' <td>Emergency Contact:</td>';
            $body .= ' <td><p class="text">'. $customer->secondary_emergency_contact .'</p></td>';
            $body .= '</tr>';
            
            $body .= '</table>';
            $body .= '<br>';
            $body .= '<hr>';
            
            // Dependents
            $body .= '<h3>Dependents</h3>';
            $body .= '<table style="width:400px;">';
            $body .= '<tr>';
            $body .= ' <td>Name</td>';
            $body .= ' <td>Age</td>';
            $body .= '</tr>';
            
            $criteria->condition = "account_id = :account_id AND customer_id = :customer_id";
            $criteria->params = array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
            );
            $dependents = Dependent::model()->findAll($criteria);
            if (!empty($dependents)) {
                foreach($dependents as $k=>$dependent) {
                    $body .= '<tr>';
                    $body .= ' <td><p class="text">'. $dependent->dependent_name .'</p></td>';
                    $body .= ' <td><p class="text">'. $dependent->dependent_age .'</p></td>';
                    $body .= '</tr>';   
                }
            }
            $body .= '</table>';
            $body .= '<br>';
            $body .= '<hr>';
            
            // Current Coverage
            $crcycle = new CDbCriteria;
            foreach(InsuranceType::getAll() as $k=>$v):                
                $cur = InsuranceType::getList($v['id']);
                if ($cur['title']!=''):
                    $crcycle->condition = "id=:account_id AND is_". $cur['title'] ."_checked = 1";
                    $crcycle->params=array(
                            ':account_id'=>Yii::app()->session['account_id'],
                    );
                    if (AccountSetup::model()->count($crcycle) > 0) {
                        $body .= '<h3>'.$cur['title'].'</h3>';
                        $body .= '<table style="width:600px;">';
                        
                        // Education
                        $body .= '<tr>';
                        $body .= ' <td><strong>Educated about:</strong></td>';
                        $body .= '</tr>';
                        $crcycle->condition = "account_id = :account_id AND customer_id = :customer_id AND policy_parent_label = :policy_parent_label";
                        $crcycle->params = array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
                            ':policy_parent_label'=> $cur['title'],
                        );
                        $educations = Education::model()->findAll($crcycle);
                        if (!empty($educations)) {
                            $body .= '<tr>';
                            $body .= ' <td>';
                            $body .= ' <span class="text"> ';
                            $arr_1 = array();
                            foreach($educations as $k=>$education) {
                                array_push($arr_1, $education->policy_child_label);
                            }
                            $body .= ''. implode(', ', $arr_1);
                            $body .= ' </span> ';
                            $body .= ' </td>';
                            $body .= '</tr>';   
                        }
                        
                        $body .= '<tr><td>&nbsp;</td></tr>';
                        
                        // Policies In Place (with Insurance Company)
                        $body .= '<tr>';
                        $body .= ' <td><strong>Coverage:</strong></td>';
                        $body .= '</tr>';
                        $crcycle->condition = "account_id = :account_id AND customer_id = :customer_id AND policy_parent_label = :policy_parent_label";
                        $crcycle->params = array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
                            ':policy_parent_label'=> $cur['title'],
                        );
                        $p_in_p = PoliciesInPlace::model()->findAll($crcycle);
                        if (!empty($p_in_p)) {
                            $body .= '<tr>';
                            $body .= ' <td>';
                            $body .= ' <span class="text"> ';
                            $arr_2 = array();
                            foreach($p_in_p as $k=>$v) {
                                array_push($arr_2, $v->policy_child_selected . '('. $v->insurance_company .')');
                            }
                            $body .= ''. implode(', ', $arr_2);
                            $body .= ' </span> ';
                            $body .= ' </td>';
                            $body .= '</tr>'; 
                        }
                        
                        $body .= '<tr><td>&nbsp;</td></tr>';
                        
                        // Concerns
                        $body .= '<tr>';
                        $body .= ' <td><strong>Concerns:</strong></td>';
                        $body .= '</tr>';
                        $concerns = GoalsConcern::model()->findAll("account_id = :account_id AND customer_id = :customer_id AND action_type = 'Concern'", array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
                        ));
                        if (!empty($concerns)) {
                            foreach($concerns as $k=>$v) {
                                $body .= '<tr>';
                                $body .= ' <td><span class="text"><img style="width:14px;height:14px;" src="/images/checkbox.jpg">&nbsp;'. $v->action_description .'</span></td>';
                                $body .= '</tr>';   
                            }
                        }
                        $topconcerns = TopConcerns::model()->findAll("account_id = :account_id AND customer_id = :customer_id", array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
                        ));
                        if (!empty($topconcerns)) {
                            foreach($topconcerns as $k=>$v) {
                                $body .= '<tr>';
                                $body .= ' <td><span class="text"><img style="width:14px;height:14px;" src="/images/checkbox.jpg">&nbsp;'. $v->concern_answer .'</span></td>';
                                $body .= '</tr>';
                            }
                        }
                        // End:Concerns
                        
                        // Life Changes
                        $body .= '<tr><td>&nbsp;</td></tr>';
                        $body .= '<tr>';
                        $body .= ' <td><strong>Life Changes:</strong></td>';
                        $body .= '</tr>';
                        
                        $lifechanges = LifeChanges::model()->findAll("account_id = :account_id AND customer_id = :customer_id", array(
                            ':account_id'=>Yii::app()->session['account_id'],
                            ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
                        ));
                        if (!empty($lifechanges)) {
                            foreach($lifechanges as $k=>$v) {
                                $body .= '<tr>';
                                $body .= ' <td><span class="text"><img style="width:14px;height:14px;" src="/images/checkbox.jpg">&nbsp;'. $v->life_answer .'</span></td>';
                                $body .= '</tr>';
                            }
                        }
                        // End:Life Changes
                        
                        $body .= '</table>';
                        $body .= '<br>';
                        $body .= '<hr>';
                    }
                endif;
            endforeach;
            
            // Goals
            $body .= '<h3>Goals</h3>';
            $body .= '<table style="width:400px;">';
            
            $criteria->condition = "account_id = :account_id AND customer_id = :customer_id AND action_type = 'Goal'";
            $criteria->params = array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
            );
            $goals = GoalsConcern::model()->findAll($criteria);
            if (!empty($goals)) {
                foreach($goals as $k=>$goal) {
                    $body .= '<tr>';
                    $body .= ' <td><p class="text">'. $goal->action_description .'</p></td>';
                    $body .= '</tr>';   
                }
            }
            $body .= '</table>';
            $body .= '<br>';
            $body .= '<hr>';
            
            // Action Items
            $body .= '<h3>Action Items</h3>';
            $body .= '<table style="width:600px;">';
            
            $criteria->condition = "account_id = :account_id AND customer_id = :customer_id";
            $criteria->params = array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
            );
            $action_items = ActionItem::model()->findAll($criteria);
            if (!empty($action_items)) {
                foreach($action_items as $k=>$action_item) {
                    $body .= '<tr>';
                    $body .= ' <td><p class="text">'. $action_item->description .'</p></td>';
                    $body .= '</tr>';   
                }
            }
            $body .= '</table>';
            $body .= '<br>';
            $body .= '<hr>';
            
            // Report Sent To
            $body .= '<h3>Report Sent to:</h3>';
            $body .= '<table style="width:400px;">';
            
            $criteria->condition = "account_id = :account_id AND customer_id = :customer_id";
            $criteria->params = array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>((isset($param['customer_id'])) ? $param['customer_id'] : 0),
            );
            $cir = CIReview::model()->find($criteria);
            if ($cir != null) {
                $body .= '<tr>';
                $body .= ' <td><p class="text">'. $cir->ci_review_submitted_to .'</p></td>';
                $body .= '</tr>'; 
            }
            $body .= '</table>';
            $body .= '<br>';
            
        }

        
        
        return array(
            'head'=> $head,
            'body'=> $body,
            'foot'=> $foot,
            'logo_pos'=> 'C'
        );
    }
}
