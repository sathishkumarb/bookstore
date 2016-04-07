<?php

class IndexController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$category = new Category();
		$category_list = $category->getCategoryList();
		$category = array();
		foreach($category_list as $list){
			$category[$list->category_id] = $list->category ;
		}
		$books = new Books();
		$books_list = $books->getNewlyAddedBooks();
		return View::make('Index/index')->with(array('category'=>$category,'books_list'=>$books_list));
		
	}
	public function addBooks(){
		$category = new Category();
		$category_list = $category->getCategoryList();
		$category = array();		 
		foreach($category_list as $list){
			$category[$list->category_id] = $list->category ;
		}		 
		return View::make('Index/add')->with(array('category'=>$category));
	}
	public function processAdd(){
		$books = new Books();
		$bookdata = array(
				'book_name' => Input::get('name'),				 
				'category_id' => Input::get('category'),
				'book_author' => Input::get('author'),				 			
			);
			// Declare the rules for the form validation.
			$rules = array(
				'book_name'  => 'Required',
				'category_id' =>'required',
				'book_author' => 'Required',				 
			);      
			$validator = Validator::make($bookdata, $rules);
			// Check if the form validates with success.
			if ($validator->passes()){
				$filename="";
				if (Input::hasFile('coverpic')){
					$name = Input::file('coverpic')->getClientOriginalName();
					$filename = time().$name;
					Input::file('coverpic')->move('bookImages/', $filename);
				}
				$data = array(
					'category_id' => Input::get('category'),				 
					'book_name' => Input::get('name'),
					'book_author' => Input::get('author'),
					'book_description' => Input::get('description'),
					'book_price' => Input::get('price'),
					'book_releasedby' => Input::get('publish_date'),
					'book_publisher' => Input::get('publisher'),
					'book_cover_pic' => $filename,
					'book_status' => 'available',					 
				); 
				$books_id = $books->Insert($data);
				return Redirect::to('bookview/'.$books_id);
			}else{
				$category = new Category();
				$category_list = $category->getCategoryList();
				$category = array();
				foreach($category_list as $list){
					$category[$list->category_id] = $list->category ;
				}		 
				return Redirect::to('add')->with(array('category'=>$category))->withErrors($validator);
			}
	}
	public function getAuthors(){
		$books = new Books();		 
		$return_array = array();
		$author = array();		 				
		$author = $books->getAllAuthors(); 
		echo json_encode($author);die();
	}
	public function getPublishers(){
		$books = new Books();		 
		$return_array = array();
		$publishers = array();		 				
		$publishers = $books->getAllPublishers(); 
		echo json_encode($publishers);die();
	}
	public function checkBookname(){
		$name = Input::get('name');
		$books = new Books();		 
		$return_array = array();
		$book_list = array();		 				
		$book_list = $books->searchBook($name); 
		echo json_encode($book_list);die();
	}
	public function bookview($id){
		if($id!='') {
			$books = new Books();	
			$book_details = $books->getBookFullDetails($id);  
			return View::make('Index/view')->with(array('book_details'=>$book_details));
		}else{
			return Redirect::to('/');
		}
	}
	public function searchBook(){
		$name = Input::get('name');
		$category = Input::get('category');
		$order = Input::get('order');
		$page = Input::get('page');
		if($page>1){
			$start = ($page-1)*10;
		}else{
			$start =0;
		} 
		$books = new Books();		 
		$return_array = array();
		$book_list = array();		 				
		$book_list = $books->searchBookAll($name,$category,$order,$start,10); 
		echo json_encode($book_list);die();
	}
	public function generateListPdf(){
		$name = Input::get('name');
		$category = Input::get('category');
		$order = Input::get('order');
		$start =0;		 
		$books = new Books();		 
		$return_array = array();
		$book_list = array();		 				
		$book_list = $books->searchBookAll($name,$category,$order,$start,1000); 
		
		require('/pdfplugin/fpdf.php');
 
		$pdf=new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		foreach($book_list as $list){
		$pdf->Cell(40,10,'Book Nmae:'.$list->book_name);
		$pdf->Ln();
		$pdf->Cell(40,10,'Category:'.$list->category);
		$pdf->Ln();
		$pdf->Cell(40,10,'Author:'.$list->book_author);
		$pdf->Ln();
		$pdf->Cell(40,10,'Publisher:'.$list->book_publisher);
		$pdf->Ln();
		$pdf->Cell(40,10,'Published Date:'.$list->book_releasedby);
		$pdf->Ln();
		$pdf->Cell(40,10,'Price:'.$list->book_price);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		}
		$pdf->Output();
		//Your HTML in a variable
		$my_html = '';
		 

		//Set Your Options -- we are saving the PDF as 'my_filename.pdf' to a 'my_pdfs' folder
		$pdf_options = array(
		  "source_type" => 'html',
		  "source" => $my_html,
		  "action" => 'save',
		  "save_directory" => 'my_pdfs',
		  "file_name" => 'my_filename.pdf');

		//Code to generate PDF file from options above
		phptopdf($pdf_options);
		 
	}
	public function booklist(){
		$name = Request::get('name');
		$category = Request::get('category');
		$order = Request::get('order');
		$page = Request::get('page');
		if($page>1){
			$start = ($page-1)*10;
		}else{
			$start =0;
		} 
		$books = new Books();		 
		$return_array = array();
		$book_list = array();		 				
		$book_list = $books->searchBookAll($name,$category,$order,$start,10);
		
		return Response::json(array(
        'error' => false,
        'urls' => $book_list),
        200
		);
	}
	 
	public function bookviewrest($id){
		if($id!='') {
			$books = new Books();	
			$book_details = $books->getBookFullDetails($id);  
			return Response::json(array(
			'error' => false,
			'urls' => $book_details),
			200
			);
		}else{
			return Response::json(array(
			'error' => true,
			'message' =>"Use book id for viewing it"),
			200
			);
		}
	}
	public function addbookrest(){
		$books = new Books();
		$bookdata = array(
			'book_name' => Request::get('name'),				 
			'category_id' => Request::get('category'),
			'book_author' => Request::get('author'),				 			
		); 
		// Declare the rules for the form validation.
		$rules = array(
			'book_name'  => 'Required',
			'category_id' =>'required',
			'book_author' => 'Required',				 
		);      
		$validator = Validator::make($bookdata, $rules);
		// Check if the form validates with success.
		if ($validator->passes()){
			$filename="";
			if (Request::hasFile('coverpic')){
				$name = Request::file('coverpic')->getClientOriginalName();
				$filename = time().$name;
				Request::file('coverpic')->move('bookImages/', $filename);
			}
			$data = array(
				'category_id' => Request::get('category'),				 
				'book_name' => Request::get('name'),
				'book_author' => Request::get('author'),
				'book_description' => Request::get('description'),
				'book_price' => Request::get('price'),
				'book_releasedby' => Request::get('publish_date'),
				'book_publisher' => Request::get('publisher'),
				'book_cover_pic' => $filename,
				'book_status' => 'available',					 
			); 
			$books_id = $books->Insert($data);
			return Response::json(array(
			'error' => false,
			'message' => 'Successfully added books',
			'bookid' => $books_id),
			200
			);
		}else{
			return Response::json(array(
				'error' => true,
				'message' => 'Name,Category and book author are Required',
				),
				200
			);
		} 
	}
	public function category(){
		 
		$category = new Category();
		$category_list = $category->getCategoryList();
		return Response::json(array(
        'error' => false,
        'urls' => $category_list),
        200
		);
	}
}
