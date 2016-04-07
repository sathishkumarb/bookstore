<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Category extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'book_categories';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $primaryKey = "category_id";
	 
	public function getCategoryList(){	
		return DB::table('book_categories')->get();
	}

	public function Insert($data){
		return DB::table('book_categories')->insert($data);
	}
	 
	public function getCategory($id){
		$users = DB::table('book_categories')->where('category_id', '=', $id)->first();
		return $users;
	}
	public function UpdateCategory($data,$id){
		return DB::table('book_categories')->where('category_id',$id)->update($data);
	}
	public function deleteCategory($id){
		return DB::table('book_categories')->where('category_id', '=', $id)->delete();
	}	 
}