<?php

class CategoryController extends BaseController {

	public function addCategory() {
		$category = Category::registerCategory(Input::all());
		return $category;
	}
	
	public function showDevices($id) {
		$retrieveItems = Item::rtvItems($id);
		return $retrieveItems;
	}

	public function editCategory($id) {
		//Search Category
		$category = Category::find($id);
		//Get All Fields where item_id = $id
		$fields = Field::where('category_id', $id)->get();
		
		//Check first if the "Search Category" returned a category...
		if($category == true) {
			return View::make('Container.edit_category_container')
				->with('category', $category)
				->with('fields', $fields);
		} else {
			return View::make('404');
		}
	}

	public function updateCategory() {
		$update_Item = Category::update_Category(Input::all());
		return $update_Item;
	}
}