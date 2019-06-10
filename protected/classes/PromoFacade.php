<?php
class PromoFacade 
{
    public static function is_promo_expired($promo_code = '0000')
    {
        $promo = Promo::model()->find('promo_code = :promo_code AND promo_end < CURDATE()', array(':promo_code'=>$promo_code));
        if ($promo != null) {
            return true;
        } else {
            return false;
        }
    }
}