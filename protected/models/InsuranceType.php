<?php
class InsuranceType extends CFormModel 
{
    
    public static function getList($id=1)
    {
        foreach(self::data() as $k=>$v) {
            if ($v['id']==$id) {
                return $v;
            }
        }
        return;
    }
    
    public static function getAll()
    {
        return self::data();
    }    
    
    
    public static function data()
    {
            return array(
                array(
                    'id'=>1,
                    'title'=>'Auto',
                    'policy_questions'=>'Do you feel sufficiently protected if you were in a vehicle accident or if your vehicle was lost or stolen?',
                    'policies_in_place'=>'What policies do you have in place to protect your vehicles?'
                ),
                array(
                    'id'=>2,
                    'title'=>'Home',
                    'policy_questions'=>'Are you comfortable with the amount of coverage you currently have on your home in case of a fire, water damage or natural disaster?',
                    'policies_in_place'=>'What policies do you have in place to protect your home?'
                ),
                array(
                    'id'=>3,
                    'title'=>'Life',
                    'policy_questions'=>'Will your family be properly cared for in the event of yours or a family members death?',
                    'policies_in_place'=>'What policies do you have in place to protect your life?'
                ),
                array(
                    'id'=>4,
                    'title'=>'Personal_Liability',
                    'policy_questions'=>'Are you prepared to cover losses of unforeseen events in which you might be held personally responsible?',
                    'policies_in_place'=>'What policies do you have in place to protect your personal liability?'
                ),
                array(
                    'id'=>5,
                    'title'=>'Disability',
                    'policy_questions'=>'If you could no longer work due to an injury, would you be able to provide for your needs?',
                    'policies_in_place'=>'What policies do you have in place to protect your disability?'
                ),
                array(
                    'id'=>6,
                    'title'=>'Health',
                    'policy_questions'=>'Are you happy with your health insurance options?',
                    'policies_in_place'=>'What policies do you have in place to protect your health?'
                ),
                array(
                    'id'=>7,
                    'title'=>'Other',
                    'policy_questions'=>'Are there other areas of risk that you don’t feel comfortable with?',
                    'policies_in_place'=>'What policies do you have in place to protect your other issues?'
                ),
                array(
                    'id'=>8,
                    'title'=>'Commercial',
                    'policy_questions'=>'Are you satisfied with the coverage you have for all businesses that you own?',
                    'policies_in_place'=>'What policies do you have in place to protect your commercial issue?'
                ),
            );
    }
}
