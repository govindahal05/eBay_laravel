<!DOCTYPE html>
<html>
<head>
	<title>Admin panel</title>
	<!-- {{ HTML::style('css/bootstrap.min.css') }} -->
	{{ HTML::style('css/styles.css') }}
</head>
<body>
	<div id="header"><h1>Library Management System</h1></div>
	
	<div id = 'navigation'>
		<h2>Admin Panel</h2>
		<h3><a href="logout">Logout</a></h3>
		<a href="addbook">Add Book</a><br />
		<a href="showbook">Show Book</a><br />
		<a href="editdeletebook">Edit | Delete Book</a><br />
	</div>
	
	<div class="view-content">
	 <h3>Welcome Admin </h3>
	@yield('content')	</div>
	
</body>
</html>
