<?php

class PoliciesForm extends AccountSetupPolicy
{

	public function rules()
	{
		return array(
			array('account_id', 'required'),
		);
	}
}

?>
