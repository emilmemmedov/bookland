<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponder;

    public function index(Request $request): JsonResponse
    {
        $books = Book::query()
            ->with([
                'authors:id,name',
                'publishers:id,name'
            ])
            ->paginate($request->get($request->get('per_page') ?? 15), [
                'id',
                'title',
                'description'
            ]);

        return $this->respond('Book List', $books);
    }
}
