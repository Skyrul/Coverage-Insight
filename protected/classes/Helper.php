<?php
class Helper {
    
    public function encrypt($plain_text='')
    {
        $key = Yii::app()->getSecurityManager()->getEncryptionKey();
        return ($plain_text!='') ? self::encrypt_blowfish($plain_text, $key) : '';
        //return utf8_encode(Yii::app()->getSecurityManager()->encrypt($plain_text));
    }
    
    public function decrypt($enc_text='')
    {
        $key = Yii::app()->getSecurityManager()->getEncryptionKey();
        return ($enc_text!='') ? self::decrypt_blowfish($enc_text, $key) : '';
        //return Yii::app()->getSecurityManager()->decrypt(utf8_decode($enc_text));
    }
    
    private function decrypt_blowfish($data,$key){
        $iv=pack("H*" , substr($data,0,16));
        $x =pack("H*" , substr($data,16));
        $res = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $x , MCRYPT_MODE_CBC, $iv);
        return $res;
    }
    
    private function encrypt_blowfish($data,$key){
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_CBC, $iv);
        return bin2hex($iv . $crypttext);
    }
}