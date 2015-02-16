<?php

class LocationController extends BaseController {



	public function addlocation() {
		$createLocation = Location::create_Location(Input::all());
		return $createLocation;
	}

	public function editLocationName() {
		# code...
		$editLocation = Location::action_LocationName(Input::all());
		return $editLocation;
	}

}