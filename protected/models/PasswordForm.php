<?php

class PasswordForm extends AccountSetup
{
	public $repeat_password;

	public function rules()
	{
		return array(
			array('password, repeat_password', 'required'),
			array('password, repeat_password', 'length', 'min'=>6),
			array('password, repeat_password', 'length', 'max'=>45),
			array('password', 'compare', 'compareAttribute'=>'repeat_password'),
		);
	}
}

?>