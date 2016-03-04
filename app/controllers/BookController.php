<?php
use Illuminate\Http\Request;
// use Libraries\Authentications\Authentication;
// use Libraries\Validations\Validator;
use Repositories\BookRepository;
class BookController extends BaseController {
	/**
	 * @param Request $request
	 * @param BookRepository $book
	 */
	public function __construct(Request $request, BookRepository $book) {
		$this->request = $request;
		$this->book = $book;
	}
	public function createbook() {
		$data =Input::all();
		$books = $this->book->add($data);
		Session::flash('message', "Book Successfully Added");
		return Redirect::back();
	}
	/**
	 * @return mixed
	 */
	public function show() {
		$books = $this->book->getAllBooks();
		return View::make('admin/view_book')->with("books", $books);
	}
	public function membershow() {
		$books = $this->book->getAllBooks();
		return View::make('members/view_book')->with("books", $books);
	}
	public function editBooks() {
		$data = $this->request->all();
		$books = $this->book->update($data);
		return Redirect::route('view');
	}
	/**
	 * @param $bookid
	 */
	public function deleteBooks($bookid) {
		$this->book->deleteBooks($bookid);
		return Redirect::back();
	}
	/*public function filterbooks() {
		# code...
		$category = \Input::get('category');
		if ($category != 'All') {
			$books = Book::where('category', '=', $category)->get();
			return View::make('user/userdashboard', ['allBooks' => $books, 'cat' => $category]); //->with("allBooks", $books);
		} else {
			$books = Book::get();
			$no = sizeof($books);
			return View::make('user/userdashboard')->with("allBooks", $books);
		}*/
	}
