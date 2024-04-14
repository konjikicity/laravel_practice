<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookPostRequest;
use App\Http\Requests\BookPutRequest;
use App\Models\Author;
use App\Models\Book;
use Exception;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
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
        try {
            DB::transaction(function () use ($request) {
                $book = Book::create([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'price' => $request->price
                ]);

                $book->authors()->attach($request->author_ids);
            });

            return redirect(route('book.index'))->with('message', $request->title . 'を追加しました。');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect(route('book.index'))->with('message', 'エラーが発生しました。再度試してください。');
        }
    }

    public function edit(Book $book): View
    {
        $categories = Category::all();
        $authors = Author::all();

        $authorIds = $book->authors()->pluck('id')->all();

        return view('admin.book.edit', compact('book', 'categories', 'authors', 'authorIds'));
    }

    public function update(BookPutRequest $request, Book $book): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $book) {
                $book->update([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'price' => $request->price
                ]);

                $book->authors()->sync($request->author_ids);
            });

            return redirect(route('book.index'))->with('message', $book->title . 'を更新しました。');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect(route('book.index'))->with('message', 'エラーが発生しました。再度試してください。');
        }
    }

    public function destory(Book $book): RedirectResponse
    {
        try {
            DB::transaction(function () use ($book) {
                $book->authors()->detach();
                $book->delete();
            });

            return redirect(route('book.index'))->with('message', $book->title . 'を削除しました。');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect(route('book.index'))->with('message', 'エラーが発生しました。再度試してください。');
        }
    }
}
