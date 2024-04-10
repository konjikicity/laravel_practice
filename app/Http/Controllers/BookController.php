<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPostRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): Collection
    {
        $books = Book::all();

        return $books;
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
        Book::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'price' => $request->price
        ]);

        return redirect(route('books.index'));
    }
}
