<!DOCTYPE html>
<html>
<head>
	<title>file upload</title>
</head>
<body>
<h1>File Upload</h1>
{{Form::open(array('url' =>'file'))}}
	<p>
	  {{Form::label('image','Image')}}
		{{Form::file('image')}}
	</p>
	{{Form::submit('upload')}}
{{Form::close()}}
</body>
</html>