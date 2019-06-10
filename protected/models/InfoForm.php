<?php

class InfoForm extends AccountSetup
{
	public function rules()
	{
		return array(
			array('first_name, last_name, office_phone_number, agency_name', 'required'),
			array('first_name, last_name', 'length', 'max'=>45),
			array('email, agency_name', 'length', 'max'=>75),
			array('timezone', 'length', 'max'=>145),
			array('first_name, last_name, email, office_phone_number, agency_name', 'safe', 'on'=>'search'),
		);
	}
}

?>
