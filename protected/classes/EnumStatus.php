<?php 

abstract class EnumStatus 
{
    const ACTIVE   = 'active';
    const INACTIVE = 'inactive';
    
    const OK = "ok";
    const ERROR = "error";
    
    const SUCCESS = "success";
    const FAIL = "fail";
    const DECLINED = "decline";
    
    // billings
    const UNPAID = 'UNPAID';
    const PAID   = 'PAID';
    
    // authorize.net payment environment 
    const SANDBOX        = 1;
    const PRODUCTION     = 0;
    
    // invoice type
    const  ENROLLMENT = 'ENROLLMENT';
    const  SUBSCRIPTION = 'SUBSCRIPTION';
    const  BUYSTAFF = 'BUYSTAFF';
    const  CANCELMEMBERSHIP = 'CANCELMEMBER';

    // email editor
    const FIXED_LAYOUT = 'fixed';
    const FLUID_LAYOUT = 'fluid';

    // email templates code
    const EMAIL_NA = "NA";
    const EMAIL_CIR = "CIR";
    const EMAIL_SA = "SA";
    const EMAIL_VC_INVITE1 = "VC1";
    const EMAIL_VC_INVITE2 = "VC2";
    
    public static function lists()
    {
        return array(
            self::ACTIVE=>'ACTIVE',
            self::INACTIVE=>'INACTIVE',
        );
    }
    
    public static function anet_environment()
    {
        return array(
            self::SANDBOX=>'Sandbox',
            self::PRODUCTION=>'Production',
        );
    }

    public static function vi_environment()
    {
        return array(
            self::SANDBOX=>'Sandbox',
            self::PRODUCTION=>'Production',
        );
    }
    
    public static function emailtemplates()
    {
        return array(
            self::EMAIL_NA =>'Need Assessment',
            self::EMAIL_CIR =>'Customer Insurance Review',
            self::EMAIL_SA =>'Staff Registration',
            self::EMAIL_VC_INVITE1 => 'Video Conference Invitation',
            self::EMAIL_VC_INVITE2 => 'Scheduled Video Conference'
        );
    }

    public static function emailtemplatesdiff()
    {
        $original = self::emailtemplates();
        $diff  = array();
        foreach($original as $k=>$v) {
            $record  = EmailTemplate::model()->find('account_id = :account_id AND code = :code', array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':code'=>$k
            ));
            if ($record == null) {
                $diff[$k] = $v;
            }
        }
        return $diff;
    }

    public static function emailtemplatesparams($code = '')
    {
        $arr = array(
            self::EMAIL_NA =>'[cust_pri_fname],[verify_link_na],[apt_date],[apt_time],[apt_location],[apt_office_num],[remotesupport]',
            self::EMAIL_CIR =>'[resources],[remotesupport]',
            self::EMAIL_SA =>'[registration_link]',
            self::EMAIL_VC_INVITE1 =>'[customer_primary],[customer_secondary],[appointment],[vc_link]',
            self::EMAIL_VC_INVITE2 =>'[customer_primary],[customer_secondary],[appointment],[vc_link],[scheduled_date],[scheduled_time]',
        );

        return (isset($arr[$code])) ? $arr[$code] : '';
    }

    public static function emaillayouts()
    {
        return array(
            self::FIXED_LAYOUT=>strtoupper(self::FIXED_LAYOUT),
            self::FLUID_LAYOUT=>strtoupper(self::FLUID_LAYOUT)
        );
    }


}

?>