@extends('layouts.default_admin')

@section('content')
<table border=1 width=700>
	<thead >
		<tr>
			<th>S|N</th>
			<th>Book hgfhgfhgName</th>
			<th>ISBN No</th>
			<th>Edition</th>
			<th>Author Name</th>
			<th>Price</th>
			<th>Category</th>
			<th>Operation</th>
		</tr>
	</thead>
	<tbody> 
	 @foreach($books as $book)
		<tr>
			<td> {{ $sno }} </td>
			<td>{{ $book->book_name}}</td>
			<td>{{ $book->isbn_no}}</td>
			<td>{{ $book->edition}}</td>
			<td>{{ $book->author_name}}</td>
			<td>{{ $book->price}}</td>
			<td>{{ $book->category}}</td>
			<td><a href="bookEdit">Edit</a>|<a href="bookDelete">Delete</a></td>
						
		</tr>
		{{ $sno++ }}
		@endforeach
	</tbody>
</table>
@stop