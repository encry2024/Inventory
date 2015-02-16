<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


#GET

//LOGOUT
Route::get('logout', function() {
	Auth::logout();
	return Redirect::to('auth/login');
});

//REDIRECT TO AUTH/LOGIN IF URL IS INVENTORY/PUBLIC/
Route::get('/', function() {
	return Redirect::to('auth/login');
});

Route::get('auth/login', function() {
	return View::make('Container.login_container');
});

Route::get('register/user', function() {
	return View::make('Container.register_user_container');
});

Route::get('mainpage', function() {
	$category = Category::all();
	return View::make('Container.mainpage_container')->with('category', $category);
});

Route::get('history', function() {
	$audits = Audit::all();
	return View::make('Container.history_container')->with('audits', $audits);
});

Route::get('category/{id}/profile', function( $id ) {
	$category = Category::find($id);
	$fields = Field::where('category_id', $id)->get();

	$devices = Device::with('location')->where('category_id', $id)->get();

	return View::make('Container.device_container')
		->with('category', $category)
		->with('fields', $fields)
		->with('device_location', $devices);
});

Route::get('getHistory', function() {
	return Audit::all()->toJson();
});

Route::get('location', function() {
	return View::make('Container.location_container');
});

Route::get('location/{id}/profile', function( $id ) {
	$location = Location::find($id);
	$device = Device::where('location_id', $id)->get();

	return View::make('Container.location_profile_container')->with('location', $location)->with('device', $device);
});

Route::get('summary', function () {
	return View::make('Container.summary_container');
});

Route::get('category/{id}/checkedout', function( $id ) {
	$category = Category::find($id);
	return View::make('Container.checkdout_container')->with('category', $category);
});

Route::get('category/{id}/disposed', function ($id) {
	$category = Category::find($id);

	return View::make('Container.disposed_container')->with('category', $category);
});

Route::get('category/{id}/available', function ($id) {
	$category = Category::find($id);

	return View::make('Container.available_container')->with('category', $category);
});

Route::get('category/add', function () {
	return View::make('Container.add_category_container');
});

Route::get('user/change_password', function() {
	return View::make('Container.change_password_container');
});

Route::get('devices/association', function() {
	return View::make('Container.associations_container');
});

Route::get('category/{id}/edit', 'CategoryController@editCategory');
Route::get('device/{id}/profile', 'DeviceController@deviceProfile');

Route::get('search/information', function() {
	return View::make('Container.info_container');
});





#JSONS

//FETCH ALL THE DEVICE'S LOGS
Route::get('getDeviceLog/{id}', function($id) {
	$json = array();
	$locationLog = DeviceLog::where('device_id', $id)->get();
	foreach ($locationLog as $location_log) {
		$json[] = array(
			'id' => $location_log->id,
			'owner_name'	=> $location_log->location->lastname . ", " . $location_log->location->firstname,
			'loc_name' 	=> $location_log->location->name,
			'dev_name' 	=> $location_log->device->name,
			'updated_at'	=> date('M d, Y [h:i A D]', strtotime($location_log->updated_at) ),
			'events' 	=> $location_log->action_taken,
			'device_id' 	=> $location_log->device_id,
			'location_id' 	=> $location_log->location_id,
		);
	}
	return json_encode($json);
});

//FETCH LOCATION DISPLAY IN ASSOCIATE MODAL ON DEVICE PROFILE
Route::get('fetch/{id}/location', function($id) {
	$json = array();

	$locations = Location::whereNotIn('id', function($query) use ($id) {
		$query->select(['location_id']); 
		$query->from('devices');
		$query->where('category_id', $id); 
	})->get();

	foreach ($locations as $loc) {
		if($loc->lastname != "" && $loc->firstname != "") {
			$json[] = array(
				'id' => $loc->id,
				'lastname' => $loc->lastname,
				'firstname' => $loc->firstname,
				'name' => $loc->name,
			);
		} else {
			$json[] = array(
				'id' => $loc->id,
				'name' => $loc->name,
			);
		}
	}

	return json_encode($json);
});

//FETCH ALL DEVICE THAT IS ASSOCIATED WITH OWNERS
Route::get('fetch/associations', function() {
	$json = array();
	$categories = Category::all();

	foreach ($categories as $ctg) {
		foreach ($ctg->devices as $device) {
			if ($device->location_id != 0) {
				$json[] = array(
					"id" 			=> $device->id,
					"category" 		=> $ctg->name,
					"category_id" 		=> $ctg->id,
					"name" 			=> $device->name,
					"location" 		=> $device->location->lastname . ", " . $device->location->firstname,
					"location_id" 		=> $device->location_id,
					"updated_at" 		=> date('M d, Y [h:i A D]', strtotime($device->updated_at)),
				);
			}
		}
	}
	return json_encode($json);
});

//FETCH ALL AVAILABLE DEVICES
Route::get('getAvailable/{id}', function( $id ) {
	$json 		= array();
	$devices 	= Device::where('category_id', $id)->where('status', "Normal")->where('status', 'ACTIVE')->where('status', 'Not Specified')->where('location_id', 0)->get();
	foreach ($devices as $device) {
		$json[] = array(
			'id' 			=> $device->id,
			'name' 			=> $device->name,
			'updated_at' 	=> date('M d, Y [h:i A D]', strtotime($device->updated_at) ),
			'availability' 	=> $device->availability,
		);
	}
	return json_encode($json);
});

//FETCH ALL DEVICES WITH NOT NORMAL STATUS
Route::get('getDisposed/{id}', function( $id ) {
	$json = array();
	$devices = Device::where('category_id', $id)->where('status', '!=', "Normal")->get();
	foreach ($devices as $device) {
		if ($device->status != "Normal"){
			$json[] = array(
				'id' 			=> $device->id,
				'name' 			=> $device->name,
				'updated_at' 	=> date('M d, Y [h:i A D]', strtotime($device->updated_at) ),
				'status' 		=> $device->status,
			);
		}
	}
	return json_encode($json);
});

//FETCH ALL CHECKED OUT DEVICES
Route::get('getChkOut/{id}', function( $id ) {
	$json = array();
	$devices = Device::with('location')->where('category_id', $id)->where('location_id', '!=', '0')->get();
	foreach ($devices as $device) {
		if ($device->location_id != 0){
			$json[] = array(
				'id' 			=> $device->id,
				'location_id' 		=> $device->location_id,
				'name' 			=> $device->name,
				'updated_at' 		=> date('M d, Y [h:i A D]', strtotime($device->updated_at) ),
				'owner_name' 		=> $device->location->lastname . ", " . $device->location->firstname,
	
			);
		}
	}
	return json_encode($json);
});

//FETCH LOGS OF SPECIFIC LOCATION
Route::get('locationLog/{id}', function ( $id ) {
	$json = array();
	$locationLog = DeviceLog::where('location_id', $id)->get();
	foreach ($locationLog as $location_log) {
		$json[] = array(
			'id' 			=> $location_log->location->id,
			'loc_name' 		=> $location_log->location->lastname . ", " . $location_log->location->firstname,
			'dev_name' 		=> $location_log->device->name,
			'created_at' 	=> date('M d, Y [h:i A D]', strtotime($location_log->created_at) ),
			'events' 		=> $location_log->action_taken,
			'device_id' 	=> $location_log->device_id,
		);
	}
	return json_encode($json);
});

//FETCH ALL LOCATIONS
Route::get('retrieve_location', function() {
	$json = array();
	$locations = Location::with('devices')->get();
	foreach ($locations as $location) {
		$json[] = array(
			'id' 			=> $location->id,
			'lastname' 		=> $location->lastname,
			'firstname' 	=> $location->firstname,
			'name' 			=> $location->name,
			'updated_at' 	=> date('m/d/Y [ h:i A D ]', strtotime($location->updated_at) ),
		);
	}
	return json_encode($json);
});


//FETCH ALL DEVICES
Route::get('getDevice/{id}', function( $id ) {
	$json = array();
	$devices = Device::with('location')->where('category_id', $id)->get();
	foreach ($devices as $device) {
		//Get information of the device
		$info =	Information::with('field')->where('device_id', $device->id)->get();
		if ($device->location_id != 0) {
			//Foreach information
			foreach ($info as $i) {
				//If the label of the information is NSI Tag
				if ($i->field->category_label == "NSI Tag") {
					//Display
					$json[] = array(
						'id' 				=> $device->id,
						'location_id' 		=> $device->location_id,
						'tag'				=> $i->value,
						'name' 				=> $device->name,
						'updated_at' 		=> date('M d, Y [h:i A D]', strtotime($device->updated_at) ),
						'status' 			=> $device->status,
						'location_name' 	=> $device->location->name,
						'owner_name'		=> $device->location->lastname . ", " . $device->location->firstname,
					);
				}
			}
		} else {
			//Foreach information
			foreach ($info as $i) {
				//If the label of the information is NSI Tag
				if ($i->field->category_label == "NSI Tag") {
					$json[] = array(
						'id' 				=> $device->id,
						'location_id' 		=> $device->location_id,
						'name' 				=> $device->name,
						'tag'				=> $i->value,
						'updated_at' 		=> date('M d, Y [h:i A D]', strtotime($device->updated_at) ),
						'status' 			=> $device->status,
						'location_name' 	=> $device->availability,
					);
				} 
			}
		}
	}
	return json_encode($json);
});

//FETCH ALL CATEGORY
Route::get('getCategory', function() {
	$json = array();
	$categories = Category::all();
	foreach ($categories as $category) {
		$json[] = array(
			'id' 				=> $category->id,
			'name' 				=> $category->name,
			'updated_at' 		=> date('m/d/Y [ h:i A D ]', strtotime($category->updated_at) ),
			'totalDevice' 		=> count($category->devices),
			'totalAvailable' 	=> count($category->availableDevices()),
			'disposedDevices'	=> count($category->disposed()),
			'checkedOut' 		=> count($category->checkedOut()),
		);
	}
	return json_encode($json);
});

//FETCH INFORMATION
Route::get('fetch/information', function() {
	$json = array();
	$information = Information::with('field')->get();
	$device = Device::all();
	foreach ($device as $d) {
		$information = Information::with('field')->where('device_id', $d->id)->get();
		foreach ($information as $i) {
			$json[] = array(
				'id' 				=> $d->id,
				'description'		=> $d->name,
				'info' 				=> $i->value,
				'field'				=> $i->field->category_label,
			);
		}
	}
	// foreach ($information as $info) {
	// 	$device = Device::all();
	// 	foreach ($device as $d) {
	// 		$json[] = array(
	// 			'id' 				=> $d->id,
	// 			'description'		=> $d->name,
	// 			'info' 				=> $info->value,
	// 			'field'				=> $info->field->category_label,
	// 		);
	// 	}
	// }
	return json_encode($json);
});






#POST
Route::any('import/{id}/data', function( $id ) {
	set_time_limit(300);
	$file = Input::file( 'file' );
	$file->move(storage_path() . '/uploads', $file->getClientOriginalName());

	$sheet = Excel::load( storage_path() . '/uploads/' . $file->getClientOriginalName())->toArray();
	$fields = Field::where('category_id', $id)->get();
	foreach ($sheet as $row) {
		$status = $row['status']==NULL?'Not Specified':$row['status'];
		$device = Device::firstOrNew(array(
			"category_id" 	=> $id,
			"location_id" 	=> 0,
			"name" 			=> $row['name'],
			"status"		=> $status,
			"comment"		=> "",
			"availability"	=> ""
		));
		$device->save();
		$field_values = array();
		foreach ($fields as $field) {
			//create array of fields to be insert
			$field_name = $field->category_label;
			if(array_key_exists($field_name, $row)) {
				$field_values[] = array(
					'device_id' => $device->id,
					'field_id'	=> $field->id,
					'value'		=> $row[$field_name]
				);
				foreach ($field_values as $f_v) {
					if ($f_v['value'] != '') {
					$information = Information::firstOrNew(array(
							'device_id' => $f_v['device_id'],
							'field_id' => $f_v['field_id'],
							'value' => $f_v['value']
						)
					);
					} else {
						$information = Information::firstOrNew(array(
								'device_id' => $f_v['device_id'],
								'field_id' => $f_v['field_id'],
								'value' => ""
							)
						);
					}
					$information->save();
				}
			} 
		}
		// 
	}
	return Redirect::back();
});

Route::post('registeruser', 'UserController@registerUser');
Route::post('addcategory','CategoryController@addCategory');
Route::post('adddevice', 'DeviceController@addDevice');
Route::post('add/location', 'LocationController@addlocation');
Route::post('assign', 'DeviceController@assignDevice');
Route::post('changestatus', 'DeviceController@changeStatus');
Route::post('update/category', 'CategoryController@updateCategory');
Route::post('update/{id}/device', 'DeviceController@updateDevInfo');

Route::post('authenticate', function() {
	$login = User::validateLogin(Input::all());
	return $login;
});

Route::post('dissociate/device/{id}', function( $id ) {
	$device = Device::find($id);
	$device->availability = "Available";
	$getLocation_id = $device->location_id;
	$device->location_id = "0";
	$device->save();

	$device_name 	= $device->name;
	$device_id 		= $device->id;

	$getLocation 		= Location::find($getLocation_id);
	$getLocation_name 	= $getLocation->name;
	$getLocation_Id 	= $getLocation->id;

	$deviceLog = new DeviceLog;
	$deviceLog->device_id = $device_id;
	$deviceLog->location_id = $getLocation_Id;
	$deviceLog->action_taken = "dissociated" ;
	$deviceLog->save();

	$audits 		= new Audit;
	$audits->user 	= Auth::user()->username;
	$audits->event 	= "Dissociate";
	$audits->field 	= $device_name;
	$audits->object = $getLocation_name;
	$audits->save();

	return Redirect::back()->with('notif', 'Success: Device was successfully dissociated.');
});

Route::post('item/{id}/delete', function($id) {
	//Search Item where id = $id
	$item 		= Item::find($id);
	$item_name 	= $item->name;

	//Delete each device that has item_id of $id
	$devices = Device::where('item_id', $id)->get();
	foreach ($devices as $device) {
		$device->delete();
	}
	
	//Save action taken on the Item.
	$audits = new Audit;
	$audits->user = Auth::user()->username;
	$audits->event = "Delete";
	$audits->field = "Device";
	$audits->object = 
	$audits->history = Auth::user()->firstname ." ". Auth::user()->lastname . " has deleted the Item " .$item_name." and all its devices permanently.";
	$audits->save();
	//Delete Item
	$item->delete();

	return  Redirect::to('/')->with('deleteMessage', 'Item deleted');
});

Route::post('device/{id}/delete', function($id) {
	//Search ID then get item_id, and name before delete
	$device 			= Device::find($id);
	$deviceCategoryId 	= $device->category_id;
	$device_name 		= $device->name;

	//Delete the device
	$device->delete();

	$category = Category::find($deviceCategoryId);

	$category->save();

	//Save action to history
	$audits = new Audit;
	$audits->user = Auth::user()->username;
	$audits->event = "Delete";
	$audits->field = "Device";
	$audits->object = $device_name;

	return  Redirect::to('category/'.$deviceCategoryId.'/profile')
		->with('deleteMessage', 'Device deleted');
});

Route::get('field/{id}/delete', function($id) {
	$field = Field::find($id);
	$fieldItemId = $field->category_id;
	$field_name = $field->category_label;

	//Get Item where ID = fieldItemId and get the name of the result...
	$getItem = Category::find($fieldItemId);
	$itemName = $getItem->name;

	//Get the Info where field_id = $id (id of a field)
	$getInfo = Information::where('field_id', $id)->get();

	//Loop through each Info and save to audit before deletion..
		$audits = new Audit;
		$audits->user = Auth::user()->username;
		$audits->event = "Delete";
		$audits->field = $itemName;
		$audits->object = $field_name;
		$audits->save();

	//Loop through info. If Info found; Delete the info...
	foreach($getInfo as $info) {
		$info->delete();
	}

	//After deleting the information of the selected field. Delete the Field...
	$field->delete();
	return Redirect::back()->with('deleteMessage', 'Field '.$field->item_label.' has been deleted.');
});

Route::post('update_password', function(){
	$user = User::find(Auth::user()->id);

	if(Hash::check(Input::get("oldPass"), Auth::user()->password)) {
		if (Input::get("newPass") == Input::get("confirmPassword")) {
			$user->password = Hash::make(Input::get("newPass"));
			$user->save();

			Auth::logout();

			return Redirect::to('/');
		} else {
			return Redirect::to('user/change_password')
			->with('message', 'Password do not match.');
		}
	} else {
		return Redirect::to('user/change_password')
		->with('message', 'Your old password is incorrect.');
	}
});