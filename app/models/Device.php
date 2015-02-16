<?php 

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Device extends Eloquent {

	
	use SoftDeletingTrait;

	protected $table = 'devices';
	protected $dates = ['deleted_at'];
	protected $softDelete = true;
	protected $fillable = array(
		'category_id',
		'location_id',
		'name',
		'status',
		'comment',
		'availability'
	);

	public function category() {
		return $this->belongsTo('Category')->withTrashed();
	}

	public function information() {
		return $this->hasMany('Information');
	}

	public function location() {
		return $this->belongsTo('Location');
	}

	public function devicelog() {
		return $this->hasMany('DeviceLog');
	}

	public function audit() {
		return $this->hasMany('Audit');
	}

	public static function registerDevice($data) {
		$values = array(
			'category_id' => $data["itemId"],
			'name' => $data['mydevice']
		);

		//rules
		$rules =array(
			//'value' => 'required',
			'category_id' => 'required',
			'name' => 'required|unique:devices,name'
		);

		$validation = Validator::make($values, $rules);

		//check if validation successful
		if($validation->fails()) {
			return Redirect::back()
				->withErrors($validation);
		} else {
			$i = 0;
			//add new device in device_tbl
			$device = new Device();
			$device->category_id = $data["itemId"];
			$device->name = trim($data['mydevice']);
			$device->status = "Normal";
			$device->availability = "Available";
			$device->save();

			$category_id = $device->category_id;
			//Increase Category Total Device
			$category = Category::find($category_id);
			$category->save();

			//Get Device ID, Name from Inserted Device
			$insertedDevId = $device->id;
			$insertedDeviceName = $device->name;

			//Get Item Name
			$find_item = Category::find($data["itemId"]);
			$item_name = $find_item->name;

			//Save action taken on Audit
			$audits = new Audit;
			$audits->user = Auth::user()->username;
			$audits->event = "Add";
			$audits->field = "Device";
			$audits->object = $insertedDeviceName;
			$audits->save();

			//loop through field arrays
			foreach($data as $key=>$value) {
				if(strpos($key,'field') !== false) {
					//get id (field-1)
					$field_Information = explode("-", $key);
					$id = $field_Information[1];

					//save in database
					$Information = new Information();
					$Information->device_id = $insertedDevId;
					$Information->field_id = $id;
					$Information->value = $value;
					$Information->save();

					$field_id = $Information->field_id;

					$audits = new Audit();
					$field = Field::where('id', $id)->get();
					$Information = Information::where('field_id', $field_id)->get();
					foreach ($field as $field) {
						foreach ($Information as $fields_Information) {
							$audits->user = Auth::user()->username;
							$audits->event = "Set";
							$audits->field = $insertedDeviceName . " &#8594; " . $field->category_label;
							$audits->object = $fields_Information->value;
							$audits->save();
						}
					}
				} else {
					continue;
				}
			}
			return Redirect::back();
		}
	}

	//UPDATE DEVICE Information

	public static function update_device_Information($data, $id) {
		$audit_history = '';
		$changesApplied = 0;

		$device_old_name = '';
		$device_new_name = '';

		$dev = Device::find($id);
		$device_old_name = $dev->name;
		$dev->name = $data["device_name"];
		$dev->save();

		$device_new_name = $dev->name;

		$audits = new Audit();
		$audits->user = Auth::user()->username;
		$audits->event = "Update";
		$audits->field = "Device" . " &#8594; " . $device_old_name;
		$audits->object = $device_new_name;
		$audits->save();

		foreach($data as $key=>$value) {
			if(strpos($key,'field') !== false) {
				//get id (field-1)
				$field_Information = explode("-", $key);
				$id = $field_Information[1];

				//save in database
				$Information = Information::find($id);
				$Information_OldValue = $Information->value;
				$Information->value = $value;
				$Information->save();

				$Information_NewValue = $Information->value;
				$field_id = $Information->field_id;

				$field = Field::find($field_id);
				$field_name = $field->category_label;

				$audits = new Audit();
				$searchInformation = Information::where('id', $id)->get();

				$device = Device::find($_POST["deviceId"]);
				$deviceName = $device->name;

				foreach ($searchInformation as $InformationValues) {
					if ($Information_OldValue != $Information_NewValue) {
						$audits->user = Auth::user()->username;
						$audits->event = "Update";
						$audits->field = $deviceName . " &#8594; " .$field_name;
						$audits->object = $Information_NewValue;
						$audits->save();
						$changesApplied++;
					}
				}
			} else {
				continue;
			}
		}
		if ($changesApplied != 0) {
			return Redirect::back()
				->with('message', 'Device Information has been changed.');
		} else {
			return Redirect::back()
				->with('message', 'No changes happened.');
		}
	}

	// //CHANGE DEVICE STATUS

	public static function changeStatus($data) {
		$device = Device::find($data["devi_Id"]);
		$device->status = $data["status"];
		$device->comment = $data["commentArea"];
		if ($device->status == 'Normal') {
			$device->availability = 'Available';
		}
		else { $device->availability = 'Not Available'; }
		$device->save();
		$device_name = $device->name;
		$device_comment = $device->comment;
		$device_status = $device->status;

		$audits = new Audit;
		$audits->user = Auth::user()->username;
		$audits->event = "Change";
		$audits->field = $device_name . " &#8594; " . "Status";
		$audits->object = $device_status;
		$audits->save();

		$audit = new Audit;
		$audit->user = Auth::user()->username;
		$audit->event = "Comment";
		$audit->field = $device_name . " &#8594; " . "Condition";
		$audit->object = $device_comment;
		$audit->save();

		return Redirect::back()
						->with('message', 'Device status updated.');
	}

	//RETRIEVE TRACKS

	public static function retrieveTrack($id) {
		# code...
		//Search device id
		$device = Device::find($id);

		//Get Item by the Device's item_id
		$item = Category::find($device->category_id);
		$itemId = $item->id;

		//Get all the Location of a specific Device
		$device_location = DeviceLog::where('device_id', $id)->orderby('created_at', 'desc')->paginate(20);

		//Get Devices with Location
		$devices = Device::with('location')->where('id', $id)->get();
		
		//Get Information value on Field
		$fields = Information::with('field')->where('device_id', $device->id)->get();

		$locations = Location::whereNotIn('id', function($query) use ($itemId) {
			$query->select(['location_id']);
			$query->from('devices');
			$query->where('category_id', $itemId);
		})->get();

		if($device == true) {
			return View::make('Container.device_profile_container')
				->with('devices', $device->category_id)
				->with('device_id', $device->id)
				->with('device_name', $device->name)
				->with('device_location', $device_location)
				->with('device', $device)
				->with('dvc', $devices)
				->with('category', $item)
				->with('info', $fields)
				->with('locations', $locations);
		} else {
			return View::make('404');
		}
	}

	public static function action_AssignDevice($data) {
		$values = array(
			'device_id' => $data["idTb"],
			'location_id' => $data["locationList"]
		);

		//rules
		$rules = array(
			'device_id' => 'required',
			'location_id' => 'required'
		);

		$validation = Validator::make($values, $rules);

		//check if validation successful
		if($validation->fails()) {
			return Redirect::back()
				->withErrors($validation);
		} else {
			//Add Device and location on Pivot Table
			$deviceLog = new DeviceLog;
			$deviceLog->device_id = $_POST["idTb"];
			$deviceLog->location_id = $data["locationList"];
			$deviceLog->action_taken = "assigned" ;
			$deviceLog->save();

			//Get Device Name and Id
			$device = Device::find($_POST["idTb"]);
			$device_name = $device->name;
			$deviceId = $device->id;

			//Get Location: Name, ID
			$locations = Location::find($data["locationList"]);
			$locationName = $locations->lastname . ", " . $locations->firstname;
			$getLocationId = $locations->id;
			
			//Save Location ID on Device and availability to Assigned
			$devices = Device::find($_POST["idTb"]);
			$devices->availability = "Assigned";
			$devices->location_id = $getLocationId;
			$devices->save();

			//Save the action taken to Audit
			$audits = new Audit;
			$audits->user = Auth::user()->username;
			$audits->event = "Assign";
			$audits->field = $device_name;
			$audits->object = $locationName;
			$audits->save();

			return Redirect::back()
				->with('message', 'The device '.$device_name.' has been assigned to '. $locationName .'.')
				->with('locations_name', $locationName);
		}
	}
}