@extends('layouts.master')

@section('title')
@parent
BookStore::Add
@stop

{{-- Content --}}
@section('content')
<div class="pricing-plans" id="prices">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h3>Add Your Books</h3>
				{{ Form::open(array('url' => 'add', 'class' => 'form-horizontal','id'=>'addBooks','files'=> true)) }}		
				  <div class="form-group">
					<label for="name">Book Name</label>
					{{ Form::text('name', Input::old('name'),array('placeholder' => 'Book Name','id'=>'name', 'class' => 'form-control')) }}
				  </div>
				  <div style="width:500px;position:relative;overflow-x:scroll;">
					<div class="similar_groups" style="display:none;"></div>
				  </div>
				 <div class="clearfix"></div>
				  <div class="form-group">
					<label for="category">Select Category</label>
					{{ Form::select('category',  $category, null,array('class'=>'form-control','id'=>'category')
						) }}
				  </div>
				  <div class="form-group" style="position:relative">
					<label for="author">Author</label>
					{{ Form::text('author', Input::old('author'),array('placeholder' => 'Author','id'=>'author','data-toggle'=>'dropdown', 'class' => 'form-control')) }}
					<ul class="dropdown-menu settings_dropdown" role="menu" aria-labelledby="author" id="author_list" style="width:100%"></ul>
				  </div>
				  <div class="form-group">
					<label for="description">About the Book</label>
					{{ Form::textarea('description', Input::old('description'),array('placeholder' => 'About the Book', 'class' => 'form-control')) }} 
				  </div>
				  <div class="form-group">
					<label for="price">Book Price $</label>
					{{ Form::text('price', Input::old('price'),array('placeholder' => 'Book Price', 'class' => 'form-control')) }} 
				  </div>
				  <div class="form-group">
					<label for="publish_date">Publishing Date</label>
					{{ Form::text('publish_date', Input::old('publish_date'),array('placeholder' => 'Publishing Date', 'id'=>'publish_date', 'class' => 'form-control')) }} 
				  </div>
				  <div class="form-group" style="position:relative">
					<label for="publisher">Publisher</label>
					{{ Form::text('publisher', Input::old('publisher'),array('placeholder' => 'Publisher','id'=>'publisher','data-toggle'=>'dropdown',  'class' => 'form-control')) }} 
					<ul class="dropdown-menu settings_dropdown" role="menu" aria-labelledby="publisher" id="publisher_list" style="width:100%"></ul>
				  </div>
				  <div class="form-group">
					<label for="coverpic">Book Cover Page Image</label>
					{{ Form::file('coverpic', array('placeholder' => 'Book Cover Page Image', 'id'=>'coverpic' )) }} 
					<div id="cover_preview"></div>
				  </div>				   
				  <a href="javascript:void(0)" class="btn btn-info" id="btn_booksubmit">Submit</a>
				{{ Form::close() }}
				<div class="clearfix"></div>
			</div>			 
		</div>
	</div>
</div>
<div class="clearfix"></div>
<script>
	var Authors = [];
	var publishers = [];
	$(document).ready(function() {		 
		$( "#publish_date" ).datepicker({ changeYear: true , dateFormat: "yy-mm-dd" });   
		LoadAuthors();
		LoadPulishers();
	});
	$(document).on("keyup","#author",function(){
		var src_author = $("#author").val();
		var author_filterd = sortAuthor(src_author); 
		var content ="";
		$.each(author_filterd, function( author_key, author_value ) { 
			content +='<li><a href="javascript:void(0)"  onclick="selectAuthor(\''+author_value.book_author+'\')">'+author_value.book_author+'</a><li>';
		});		 
		$('#author_list').html(content);	
	});
	$(document).on("keyup","#publisher",function(){
		var src_publisher = $("#publisher").val();
		var publisher_filterd = sortPulishers(src_publisher); 
		var content ="";
		$.each(publisher_filterd, function( publisher_key, publisher_value ) { 
			content +='<li><a href="javascript:void(0)"  onclick="selectPublisher(\''+publisher_value.book_publisher+'\')">'+publisher_value.book_publisher+'</a><li>';
		});		 
		$('#publisher_list').html(content);	
	});
	$(document).on("change","#coverpic",function(){ 
		readURL(this); 
	});
	$(document).on("click","#btn_booksubmit",function(){
		if($("#name").val()==''){
			alert("Book name required");
		}else if($("#author").val()==''){
			alert("Author name required");
		}else{ 
			$("#addBooks").submit();
		}
	});
	$(document).on("blur","#name",function(){
		var url = "{{{ URL::to('checkBookname') }}}";		 
		$.ajax({
		type: 'GET',
		url: url,
		data: 'name='+$("#name").val(),		 
		dataType:'json',
		success: function(response) {
			var content= '';
			if(response){
				$.each(response, function( book_key, book_value ) {					 
					content+= '<div style="width:200px;float:left;"><h5><a href="bookview/'+book_value.book_id+'">'+book_value.book_name+'</a></h5>';
					content+= '<div class="pricing-grids">';
					content+= '<div class="pricing-grid">';	
					content+= '<div class="price-value">Author:'+book_value.book_author;
					content+= '</div>';
					content+= '<div class="price-value">Category:'+book_value.category;
					content+= '</div>';
					content+= '<div class="price-value">Price:'+book_value.book_price;
					content+= '</div>';
					content+= '<div class="price-value">Publisher:'+book_value.book_publisher;
					content+= '</div>';	
					content+= '</div>';					
					content+= '</div>';
					content+= '</div>';
				});
			}
			$('.similar_groups').html(content);
			$('.similar_groups').show();
		} 
		}); 	
	});
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#cover_preview').html('<img src="'+e.target.result+'" width="150px" />');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	function LoadAuthors(){
		var url = "{{{ URL::to('getAuthors') }}}";		 
		$.ajax({
		type: 'GET',
		url: url,
		data: '',		 
		dataType:'json',
		success: function(response) {			 
			if(response){
				Authors = response;
			}
		} 
		}); 	
	}
	function LoadPulishers(){
		var url = "{{{ URL::to('getPublishers') }}}";		 
		$.ajax({
		type: 'GET',
		url: url,
		data: '',		 
		dataType:'json',
		success: function(response) {			 
			if(response){
				publishers = response;
			}
		} 
		}); 	
	}
	function sortAuthor(search_term) {
		var result = []; 
		var search = new RegExp(search_term , "i");
		jQuery.map(Authors, function (value) { 
			  if(value.book_author.match(search)) result.push(value);						  
			}
		);
		return result;
	}
	function sortPulishers(search_term) {
		var result = []; 
		var search = new RegExp(search_term , "i");
		jQuery.map(publishers, function (value) { 
			  if(value.book_publisher.match(search)) result.push(value);						  
			}
		);
		return result;
	}
	function selectAuthor(value){
		$('#author').val(value);		 
	}
	function selectPublisher(value){
		$('#publisher').val(value);		 
	}
</script>
@stop