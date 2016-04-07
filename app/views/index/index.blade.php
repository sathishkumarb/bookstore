@extends('layouts.master')

@section('title')
@parent
BookStore
@stop

{{-- Content --}}
@section('content')
<div class="images-slider">			 
	<div id="fwslider">
		<div class="slider_container">
			<div class="slide"> 		                
				<img src="images/banner.jpg" alt="" class="banner_image" />		             
				<div class="slide_content">
					<div class="slide_content_wrap">		                                            
						<div class="buttons">
							<div class="input-group">
							<input type="text" id="search_book" class="form-control" name="search_book" value="" placeholder="Search your book" />
							<div class="input-group-addon search_button_outer"><button type="submit" class="btn btn-info" id="btn_search">Search</button></div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>		                
			</div>	            
		</div>
		<div class="timers"> </div>
		<div class="slidePrev"><span> </span></div>
		<div class="slideNext"><span> </span></div>
	</div>
	<!--/slider -->
</div>
<div class="pricing-plans" id="prices">
	<div class="container">
		<div class="row">
			<div style="width:400px" class="pull-right">
			<div style="display:inline-block"><select id="category" name="category" class="form-control">
				<option value="">All Category</option>
				@foreach($category as $index =>$result)
				<option value="{{$index}}">{{$result}}</option>
				@endforeach
			</select></div>
			<div style="display:inline-block"><select id="orderby" name="orderby" class="form-control">
				<option value="">Sort</option>
				<option value="book_price">Price</option>
				<option value="book_name">Title</option>
				<option value="book_releasedby">Publish Date</option>
			</select></div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12">
				<h3 style="padding-bottom:25px;">Our Books</h3>
				<div class="pricing-grids" id="book_list">
					@foreach($books_list as $index =>$result)
					<div class="pricing-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">							
						 @if ($result->book_cover_pic!='')
						<div style="min-height:150px;"><img width="150px" src="{{ URL::asset('bookImages')}}/{{$result->book_cover_pic}}" /></div> 
						@endif
						<div class="clearfix"></div>
						<h5><a href="bookview/{{$result->book_id}}">{{$result->book_name}}</a></h5>
						<div class="clearfix"></div>						 
						<div>Category: {{$result->category}} </div> 
						<div class="clearfix"></div>
						<div>Author: {{$result->book_author}} </div> 
						<div class="clearfix"></div>
						<div>Publisher: {{$result->book_publisher}} </div> 
						<div class="clearfix"></div>
						<div>Published Date: {{$result->book_releasedby}} </div> 
						<div class="clearfix"></div>
						<div>Price: {{$result->book_price}} </div> 
						<div class="clearfix"></div>
					</div>
					@endforeach
				</div>
				<div class="clearfix"></div>
				<div id="loadmore"><a href="javascript:void(0)" onclick="loadmore()">Load more</a></div>
				<div class="clearfix"></div>
			</div>			 
		</div>
	</div>
</div>
<div class="clearfix"></div>
<script>
	var page = 1;
	$(document).on("click","#btn_search",function(){
		loadBooks();
	});
	$(document).on("change","#category",function(){
		loadBooks();
	});
	$(document).on("change","#orderby",function(){
		loadBooks();
	});
	function loadmore(){page++;loadBooks();};
	function loadBooks(){
		var url = "{{{ URL::to('searchBook') }}}";	
		if(page==1){
		$('#book_list').html('<img src="images/ajax_loader.gif" />');
		}
		$.ajax({
		type: 'GET',
		url: url,
		data: 'name='+$("#search_book").val()+'&category='+$("#category").val()+'&order='+$("#orderby").val()+'&page='+page,		 
		dataType:'json',
		success: function(response) {
			var content= '';
			if(response.length>0){
				$.each(response, function( book_key, book_value ) {	
					
					content+= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
					if(book_value.book_cover_pic!='')
					content+= '<div style="min-height:150px;"><img width="150px" src="{{ URL::asset("bookImages")}}/'+book_value.book_cover_pic+'" /></div>'; 
					content+= '<h5><a href="bookview/'+book_value.book_id+'">'+book_value.book_name+'</a></h5>';
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
					$("#loadmore").show();
				});
			}else{
				$("#loadmore").hide();
			}
			if(page==1){
				$('#book_list').html(content);
			}else{
				$('#book_list').append(content);
			}
			//$('.similar_groups').show();
		} 
		}); 
	}
</script>
@stop