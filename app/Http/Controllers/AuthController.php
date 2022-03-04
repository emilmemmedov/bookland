<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponder;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login','register']]);
    }

    /**
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'type' => 'required|in:' . User::AUTHOR_TYPE . ',' . User::PUBLISHER_TYPE
        ]);

        User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'type' => $request->get('type')
        ]);

        return $this->respond('User Saved');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return $this->respond('Logged in',[
            'token' => $token
        ]);
    }
}
