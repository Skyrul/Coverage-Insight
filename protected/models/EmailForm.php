<?php

class EmailForm extends AccountSetup
{

	public function rules()
	{
		return array(
			array('smtp_type, smtp_server, smtp_username, smtp_password, smtp_port', 'required'),
			array('smtp_type, smtp_server, smtp_username, smtp_password, smtp_port', 'length', 'max'=>255),
		);
	}
}

?>