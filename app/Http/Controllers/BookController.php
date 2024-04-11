<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPostRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::all();

        return view('admin.book.index', compact('books'));
    }

    public function show(string $id): Book
    {
        $book = Book::findOrFail($id);

        return $book;
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('admin.book.create', compact('categories'));
    }

    public function store(BookPostRequest $request): RedirectResponse
    {
        $book = Book::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'price' => $request->price
        ]);

        return redirect(route('books.index'))->with('message', $book->title . 'を追加しました。');
    }
}
