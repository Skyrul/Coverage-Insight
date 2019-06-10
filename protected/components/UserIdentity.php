<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $id;
 
    public function authenticate()
    {
        
        $record=User::model()->findByAttributes(array('email'=>$this->username));
        if($record===null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }            
        else
        {
            $sec = new Helper();
            $apass = trim($sec->decrypt($record->password));
            $bpass = trim($this->password);
            if ($apass !== $bpass) {
//                 echo $apass;
//                 echo $bpass;
//                 exit;
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            } else {
                $this->id=$record->id;
                $this->setState('roles', $record->roles);
                $this->setState('security_group_id', $record->security_group_id);
                $this->errorCode=self::ERROR_NONE;
                
                // Save account_id for user
                Yii::app()->session['account_id'] = $record->account_id;
            }
        }
        return !$this->errorCode;
    }
 
    public function getId(){
        return $this->id;
    }
    
}