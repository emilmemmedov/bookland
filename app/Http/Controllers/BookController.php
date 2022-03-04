<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UserBook;
use App\Traits\ApiResponder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

    /**
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->authorize('create-book');

        $this->validate($request,[
            'title',
            'description'
        ]);

        DB::transaction(function ($query) use ($request) {
            $book = Book::query()->create([
                'title' => $request->get('title'),
                'description' => $request->get('description')
            ]);

            UserBook::query()->create([
                'book_id' => $book->getKey(),
                'user_id' => Auth::id()
            ]);
        });

        return $this->respond('Book saved');
    }
}
