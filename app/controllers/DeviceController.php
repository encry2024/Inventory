<?php

class DeviceController extends BaseController {

	public function updateDevInfo($id) {
		$update_device_information = Device::update_device_Information(Input::all(), $id);
		return $update_device_information;
	}

	public function addDevice() {
		$device = Device::registerDevice(Input::all());
		return $device;
	}

	public function assignDevice() {
		$assign_device = Device::action_AssignDevice(Input::all());
		return $assign_device;
	}

	public function unassignDevice($id) {
		$device_location = Device::unAssignDevice(Input::all());
		return $device_location;
	}

	public function changeStatus() {
		$device_status = Device::changeStatus(Input::all());
		return $device_status;
	}

	public function deviceProfile($id) {
		$retrieveTrack = Device::retrieveTrack($id);
		return $retrieveTrack;
	}

}