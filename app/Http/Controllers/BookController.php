<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPostRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::with('category:id,title')->get();

        return view('admin.book.index', compact('books'));
    }

    public function show(Book $book): View
    {
        $book->load('category:id,title', 'authors:id,name');

        return view('admin.book.show', compact('book'));
    }

    public function create(): View
    {
        $categories = Category::select('id', 'title')->get();
        $authors = Author::select('id', 'name')->get();

        return view('admin.book.create', compact('categories', 'authors'));
    }

    public function store(BookPostRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $book = Book::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'price' => $request->price
            ]);

            $book->authors()->attach($request->author_ids);
        });

        return redirect(route('books.index'))->with('message', $request->title . 'を追加しました。');
    }
}
