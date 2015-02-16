<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Location extends Eloquent {

	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $dates = ['deleted_at'];
	
	protected $fillable = array(
		'id',
		'name'
	);

	public function devices() {
		return $this->hasMany('Device');
	}

	public function audits() {
		return $this->hasMany('Audit');
	}

	public function devicelogs() {
		return $this->hasMany('DeviceLog');
	}

	public static function create_location($data) {
		$values = array(
			'lastname' => $data['lname'],
			'firstname' => $data['fname']


		);

		//rules
		$rules =array(
			'lastname' => 'required', 
			'firstname' => 'required|unique:locations,firstname'
		);

		$validation = Validator::make($values, $rules);

		//check if validation successful
		if($validation->fails()) {
			return Redirect::back()
				->withErrors($validation);
		} else {

			
				$location = new Location;
				$location->lastname = trim($data['lname']);
				$location->firstname = trim($data['fname']);
				$location->name = trim($data['locationTb']);
				$location->save();

				$location_name = $location->name;

				$audits = new Audit;
				$audits->user = Auth::user()->username;
				$audits->event = "Add";
				$audits->field = "Location";
				$audits->object = $location_name;
				$audits->save();

				return Redirect::back();
			
		}
	}

	public static function action_LocationName($data) {
		$audit_history = '';
		$changesApplied = 0;

		foreach($data as $key=>$value) {
			if(strpos($key,'location') !== false) {
				//get id (field-1)
				$location_info = explode("-", $key);
				$id = $location_info[1];

				//save in database
				$location = Location::find($id);
				$location_oldName = $location->name;
				$location->name = $value;
				$location->save();

				//get updated location name
				$location_newName = $location->name;

				$audits = new Audit();
				$searchInfo = Location::where('id', $id)->get();

				foreach ($searchInfo as $locationValue) {
					if ($location_oldName != $locationValue->name) {
						$audit_history = $audits->history;
						$audits->history = Auth::user()->firstname ." ". Auth::user()->lastname . " changed the Location name from " . $location_oldName . " to " . $locationValue->name .".";
						$audits->save();
						$changesApplied++;
					} else {
						$audit_history = $audits->history;
						$audits->history = Auth::user()->firstname ." ". Auth::user()->lastname . " made no changes on Location ".$locationValue->name.".";
						$audits->save();
					}
				}
			} else {
				continue;
			}
		}
		if ($changesApplied != 0) {
			return Redirect::back()
				->with('message', 'Location Name has been changed.');
		} else {
			return Redirect::back()
				->with('message', 'No changes happened.');
		}
	}

	public function getAssocDev() {
		$arr[] = array();
		$location = Location::all();
		foreach ($location as $loc) {
			foreach ($loc->devices as $loc_dev) {
				$arr[] = array("assoc_dev"=>$loc_dev->name);
			}
		}
		return $arr;
	}
}