<?php

class ColourForm extends AccountSetup
{
	public function rules()
	{
		return array(
			array('colour_scheme_id', 'required'),
		);
	}
}

?>