<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function create(Book $book)
    {
//        if (Auth::guest()) {
//            return redirect('login');
//        }
        return view('books.create', ['books'=>$book]);
    }

    public function index(Book $book)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
//        if ($book->user()->is(Auth::user())) {
//            return view('books.index', ['books' => book::all()->sortByDesc('created_at')]);
//        }
//        abort(404);
        return view('books.index', ['books' => Book::all()->sortByDesc('created_at')]);

    }

    public function show(Book $book)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        return view('books.show', ['book' => $book]);
    }

    public function store()
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        request()->validate([
            'book_name' => ['required', 'min:3'],
            'author' => ['required'],
            'text' => ['required']
        ]);
        Book::create([
            'book_name' => request('book_name'),
            'author' => request('author'),
            'text' => request('text'),
            'user_id' => Auth::user()->id
        ]);
        return redirect('/books/index');
    }

    public function edit(Book $book)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        return view('books.edit', ['book' => $book]);

    }

    public function update(Book $book)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        request()->validate([
            'book_name' => ['required'],
            'author' => ['required'],
            'text' => ['required']
        ]);
        $book->update([
            'book_name' => request('book_name'),
            'author' => request('author'),
            'text' => request('text')
        ]);
        return redirect('/books/' . $book->id);
    }

    public function delete(Book $book)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        $book->delete();
        return redirect('/books/index');
    }
}
