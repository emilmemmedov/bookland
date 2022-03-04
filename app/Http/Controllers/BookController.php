<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponder;

    public function index(Request $request){
        $books = Book::query()
            ->with([
                'authors:id,name'
            ])
            ->get([
                'id',
                'title',
                'description'
            ]);

        return $this->respond('Book List', $books);
    }
}
