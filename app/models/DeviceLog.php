<?php 

class DeviceLog extends Eloquent {

	public function device() {
		return $this->belongsTo('Device')->withTrashed();
	}

	public function location() {
		return $this->belongsTo('Location');
	}

}