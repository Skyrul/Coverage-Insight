<?php

abstract class ChargesFacade
{
    
    public static function fees()
    {
        $model = ChargesFee::model()->find('is_primary = 1');
        return $model;
    }
    
}