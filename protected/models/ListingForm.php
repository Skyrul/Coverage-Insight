<?php

class ListingForm extends AccountSetup
{

	public function rules()
	{
		return array(
			array('apointment_locations, staff', 'length', 'max'=>1000),
		);
	}
}

?>