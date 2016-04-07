@extends('layouts.master')

@section('title')
@parent
BookStore::{{$book_details->book_name}}
@stop

{{-- Content --}}
@section('content')
<div class="pricing-plans" id="prices">
 
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>{{$book_details->book_name}}</h3>
				 @if ($book_details->book_cover_pic!='')
				<div><img src="{{ URL::asset('bookImages')}}/{{$book_details->book_cover_pic}}" /></div> 
				@endif
				<div class="clearfix"></div>
				<div>About this book:<p>{{$book_details->book_description}}</p></div> 
				<div class="clearfix"></div>
				<div>Category: {{$book_details->category}} </div> 
				<div class="clearfix"></div>
				<div>Author: {{$book_details->book_author}} </div> 
				<div class="clearfix"></div>
				<div>Publisher: {{$book_details->book_publisher}} </div> 
				<div class="clearfix"></div>
				<div>Published Date: {{$book_details->book_releasedby}} </div> 
				<div class="clearfix"></div>
				<div>Price: {{$book_details->book_price}} </div> 
				<div class="clearfix"></div>
				<div>Share this: <a href="javascript:void(0)" id="share_button">Facebook</a><div class="g-plus" data-action="share" data-href="http://localhost/bookstore/public/bookview/{{$book_details->book_id}}"></div><a href="https://twitter.com/share" class="twitter-share-button" >Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
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
		$( "#publish_date" ).datepicker({ changeYear: true });   
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
					content+= '<div class="col-md-1"><h3>'+book_value.book_name+'</h3>';
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
	$(document).ready(function(){
		$('#share_button').click(function(e){
			e.preventDefault();
			FB.ui(
			{
			method: 'feed',
			name: '{{$book_details->book_name}}',
			link: 'http://localhost/bookstore/public/bookview/{{$book_details->book_id}}',
			picture: '{{ URL::asset('bookImages')}}/{{$book_details->book_cover_pic}}',
			caption: '{{$book_details->book_description}}',
			message: ''
			});
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