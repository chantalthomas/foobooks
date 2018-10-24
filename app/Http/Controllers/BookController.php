<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index');
    }

    public function showBook($title)
    {
        return view('books.showBook')->with(['title' => $title]);
    }
}
