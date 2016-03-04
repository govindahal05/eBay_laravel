<!DOCTYPE html>
<html>
<head>
	<title>Member panel</title>
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/styles.css') }}
</head>
<body>
	<div id="header"><h1>Library Management System</h1></div>
	
	<div id = 'navigation'>
		<h2>Member Panel</h2>
		<h3><a href="logout">Logout</a></h3>
		<a href="displaybook">List Book</a><br />
		<a href="booktaken"> Issued Book</a>
	</div>
	
	<div class="view-content">
	@if (Session::has('message'))
         <div class="regalert">{{ Session::get('message') }}</div>
     @endif
		<h2>Welcome {{ Session::get('username') }} </h2>
		@yield('content') 
	</div>
	
</body>
</html>
