<?php 

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Field extends Eloquent {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $dates = ['deleted_at'];

	public function item() {
		return $this->belongsTo('Item')->withTrashed();
	}

	public function audit() {
		return $this->hasMany('Audit');
	}

	public function information() {
		return $this->hasMany('Information');
	}
}