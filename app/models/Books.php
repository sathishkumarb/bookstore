<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Books extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	protected $primaryKey = "book_id";
	 
	public function getBookList(){	
		return DB::table('books')->get();
	}

	public function Insert($data){
		//DB::table('customer')->insert($data);
		$id = DB::table('books')->insertGetId($data);
		return $id;
	}
	 
	public function getBook($id){
		$books = DB::table('books')->where('book_id', '=', $id)->first();
		return $books;
	}
	public function UpdateBook($data,$id){
		return DB::table('books')->where('book_id',$id)->update($data);
	}
	public function deleteBook($id){
		return DB::table('books')->where('book_id', '=', $id)->delete();
	}	 
	public function getBookFullDetails($id){
		$books = DB::table('books')->join('book_categories', 'book_categories.category_id', '=', 'books.category_id')->where('books.book_id', '=', $id)->first();
		return $books;		
	}
	public function getNewlyAddedBooks(){
		$books = DB::table('books')->join('book_categories', 'book_categories.category_id', '=', 'books.category_id')->orderBy('book_added_date', 'desc')->take(10)->get();
		return $books;		
	}
	public function getAllAuthors(){
		$books = DB::table('books')->select('book_author')->get();
		return $books;		
	}
	public function getAllPublishers(){
		$books = DB::table('books')->select('book_publisher')->get();
		return $books;		
	}
	public function searchBook($str_name){
		$books = DB::table('books')->join('book_categories', 'book_categories.category_id', '=', 'books.category_id')->where('book_name', 'like','%'.$str_name.'%')->get();
		return $books;	
	}
	public function searchBookAll($str_name,$category,$order,$start,$limit){
		$books_query = DB::table('books')->join('book_categories', 'book_categories.category_id', '=', 'books.category_id');
		if($str_name!=''){
			$books_query->where('book_name', 'like','%'.$str_name.'%')->orWhere('book_author', 'like','%'.$str_name.'%')->orWhere('book_categories.category', 'like','%'.$str_name.'%');
		}
		if($category!=''){
			$books_query->where('books.category_id', '=',$category);
		}
		if($order!=''){
			$books_query->orderBy($order, 'ASC');
		}
		$books = $books_query->skip($start)->take($limit)->get();
		return $books;
	}
}