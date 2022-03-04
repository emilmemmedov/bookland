<?php

namespace App\Http\Controllers;

use App\Models\UserBook;
use App\Traits\ApiResponder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PublisherController extends Controller
{
    use ApiResponder;

    /**
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->authorize('publish-book');

        $this->validate($request, [
            'book_id' => 'required|exists:books,id'
        ]);

        UserBook::query()->create([
           'book_id' => $request->get('book_id'),
           'user_id' => Auth::id()
        ]);

        return $this->respond('Book Published');
    }
}
