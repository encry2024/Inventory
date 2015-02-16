<?php 

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Information extends Eloquent {

	use SoftDeletingTrait;
	protected $table = 'information';
	protected $softDelete = true;
	protected $dates = ['deleted_at'];
	protected $fillable = array(
		'device_id',
		'field_id',
		'value'
	);

	public function devices() {
		return $this->belongsToMany('Device');
	}

	public function field() {
		return $this->belongsTo('Field')->withTrashed();
	}

	public function audit() {
		return $this->hasMany('Audit');
	}
}