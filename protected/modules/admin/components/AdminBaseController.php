<?php
class AdminBaseController extends BaseController 
{

    public $layout = '//layouts/column1_admin';
    
    /* back text */
    public $back_text = "Back";
    
    /**
     * Return Module URL
     */
    protected function moduleURL($controller_name = '') { 
        return $this->programURL() . '/' . $this->module->id . '/' . $controller_name;
    }   
    
    
}