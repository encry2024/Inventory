<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Category extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	//protected $table = 'inv_categories';
	protected $softDelete = true;
	protected $dates = ['deleted_at'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $fillable = array(
		'name',
		'item_data',
		'label'
	);

	public function field() {
		return $this->hasMany('Field');
	}

	public function device() {
		return $this->hasMany('Device');
	}

	public function devices() {
		return $this->hasMany('Device');
	}

	public function audit() {
		return $this->hasMany('Audit');
	}

    public function devicelog() {
        return $this->hasManyThrough('DeviceLog', 'Device', 'item_id', 'device_id')->orderBy('created_at', 'desc');
    }

	public static function registerCategory($data) {

		$values = array(
			'name' 		=> $data['itemTb'],
			'item_data' => $_POST["mytext"]
		);

		//rules
		$rules =array(
			'name' 		=> 'required|unique:categories,name',
			'item_data' => 'required'
		);

		$validation = Validator::make($values, $rules);

		//check if validation successful
		if($validation->fails()) {
			return Redirect::back()
				->withErrors($validation);
		} else {
			//add new item in item_tbl
			$category = new Category;
			$category->name = $data['itemTb'];
			$category->save();

			//get name and id
			$category_name = $category->name;
			$insertedId = $category->id;

			//save actions in audit
			$audits = new Audit;
			$audits->user = Auth::user()->username;
			$audits->event = "Add";
			$audits->field = "Category";
			$audits->object = $category_name;
			$audits->save();

			$audits = new Audit;

			foreach($_POST["mytext"] as $labelField) {
				if($labelField != '') {
					$field = new Field;

					//$field = new Item;
					$field->category_id = $insertedId;
					$field->category_label = $labelField;
					$field->save();

					$field_name = $field->category_label;

					//Separate each field with comma ,
					$field_array = implode(", ", array_values(($_POST["mytext"])));

					//Save the added field on the history.
					$audits->user = Auth::user()->username;
					$audits->event = "Set";
					$audits->field = $category_name;
					$audits->object = $field_array;
					$audits->save();
				}
			}
			return Redirect::back()
				->with('message', "Category has been successfully saved.");
		}
	}

	public static function update_Category($data) {
		$changesApplied = 0;
		
		//Update fields on a specific item
		foreach($data as $key=>$value) {
			if ($value != '') {
				if(strpos($key,'field') !== false) {
					//get id (field-1)
					$field_info = explode("-", $key);
					$id = $field_info[1];

					//Search, and update the field on the database
					$field = Field::find($id);

					//Get first the label before Update
					$field_old_label = $field->category_label;
					$field->category_label = $value;
					$field->save();

					//Get Field ID
					$fieldId = $field->id;

					//Get the latest field Value
					$field_new_label = $field->category_label;

					//Save the updates happened on each fields on the history.
					$audits = new Audit;
					$searchId = Field::where('id', $id)->get();

					foreach ($searchId as $fieldValues) {
						if ($field_old_label != $field_new_label) {
							$audits->user = Auth::user()->username;
							$audits->event = "Update";
							$audits->field = $fieldValues->category_label;
							$audits->object = $data["iName"];
							$audits->save();
							$changesApplied++;
						}
					}
				}
			}
		}

		//Add fields on a specific item
		if (isset($_POST["mytext"]) != '') {
			foreach($_POST["mytext"] as $labelField) {
				if ($labelField != '') {

					$field = new Field;
					$field->category_id = $_POST["iId"];
					$field->category_label = $labelField;
					$field->save();

					$field_id = $field->id;
					$device = Device::where('category_id', $data["iId"])->get();
					foreach ($device as $d) {
						$info = new Information();
						$info->device_id = $d->id;
						$info->field_id = $field_id;
						$info->value = "";
						$info->save();
					}
					$newField = $field->category_label;

					$audits = new Audit;
					
					//Save the added field on the History
					$audits->user = Auth::user()->username;
					$audits->event = "Adds";
					$audits->field = $newField;
					$audits->object = $data["iName"];
					$audits->save();
					$changesApplied++;
				}
			}
		}
		if ($changesApplied != 0) {
			return Redirect::back()->with('message', 'Changes on Fields was successful.');
		} else {
			return Redirect::back()->with('message', 'Nothing were applied.');
		}
	}

	public static function rtvItems($id) {
		$item 		= Category::find($id);
		$dev 		= Device::where('category_id', $id)->where('location_id', '!=', '')->get();
		$device 	= Device::where('category_id', $id)->get();
		$locations 	= Location::whereNotIn('id', function($query) use ($id) {
					    $query->select(['location_id']); 
					    $query->from('devices');
					    $query->where('category_id', $id); 
						})->get();
		$devices 	= Device::with('location')->where('category_id', $id)->paginate(20);

		if(count($device) != 0) {
			return View::make('Item')
				->with('item', $item)
				->with('devices', $item->devices)
				->with('locations', $locations)
				->with('device_location', $devices)
				->with('dvce', $device)
				->with('dev', $dev);
		} else {
			return View::make('Item')
				->with('item', $item)
				->with('devices', $item->devices)
				->with('device_location', $devices)
				->with('dvce', $device)
				->with('dev', $dev);
		}
	}

	public function availableDevices() {
		return $this->devices()->where('location_id', '=', 0)->Where('status', 'Normal')->orWhere('status', 'ACTIVE')->get();
	}

	public function checkedOut() {
		return $this->devices()->where('location_id', '!=', 0)->get();
	}

	public function disposed() {
		return $this->devices()->where('status', 'Retired')->orwhere('status', 'Defective')->orwhere('status','INACTIVE')->get();
	}
}