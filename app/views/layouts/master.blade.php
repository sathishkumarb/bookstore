<!DOCTYPE html>
<html>
    <head>
        <title>
            @section('title')
            
            @show
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- CSS are placed here -->
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/theme.css') }}
        {{ HTML::style('css/jquery-ui.css') }}
		{{ HTML::script('js/jquery-1.11.1.min.js') }}
		{{ HTML::script('js/responsive.menu.js') }}
		{{ HTML::script('js/jquery-ui.min.js') }}
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <style>
        @section('styles')
             
        @show
        </style>
    </head>

    <body>
		<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
        <!-- Navbar -->
		<div class="header-bg" id="home">
            <div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="logo"><h1><a href="{{{ URL::to('/') }}}">BookStore</a></h1></div>
					</div>
					<div class="col-md-8">	
						<div class="h_right">
							<div class="left">
								<ul class="menu list-unstyled">		
									<li class="active"><a href="{{{ URL::to('/') }}}" class="scroll">Home</a></li>
								</ul>
						    </div>
						    <div class="right">
								<ul class="menu list-unstyled">
									<li class="login">
										<div class="log_box">
											 <div id="loginContainer">
												<a href="{{{ URL::to('add') }}}" id="loginButton" class=""><span>Add Books</span></a>
											</div>
											<div class="clearfix"></div>
										</div>
									</li>
								</ul>
						    </div>
							<nav class="nav">
					            <ul class="nav-list">
					                <li class="nav-item"><a href="#home">Home</a></li>
					                <li class="nav-item"><a href="#features" class="scroll">Features</a></li>
					                <li class="nav-item"><a href="#prices" class="scroll">Prices</a></li>
					                <li class="nav-item"><a href="#faq" class="scroll">Faq</a></li>
					                <li class="nav-item"><a href="#support" class="scroll">Support</a></li>				               
					                <div class="clearfix"></div>		
					            </ul>					            
				
					        <div class="nav-mobile"></div></nav>					        
					         
						</div>
					</div>
				</div>
			</div>			
        </div> 
		 @yield('content')	
        <!-- Container -->
        <div class="container">

            <!-- Success-Messages -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success</h4>
                    {{{ $message }}}
                </div>
            @endif

            <!-- Content -->
           

        </div>
		<div class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12">	
						<div class="copy-right">
							<p>&#169Copyright 2014 All Rights Reserved </p>	
						</div>	
					</div>
				</div>
			</div>
		</div>
        <!-- Scripts are placed here -->
       
        {{ HTML::script('js/bootstrap.min.js') }}

    </body>
</html>