<?php

class LogoForm extends AccountSetup
{
	public function rules() {
		return array(
			array('logo', 
				  'file', 'types'=>'jpg, gif, png', 
				  'allowEmpty'=>false,
				  'maxSize'=>1024 * 1024 * 1,
				  'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.',
				  'on'=>'update',
				  'on'=>'insert'
			),
		);
	}
}

?>