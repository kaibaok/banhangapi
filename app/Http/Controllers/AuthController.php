<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $ttl = ($request->remember_me == true) ?
            env('JWT_REMEMBER_TTL') : env('JWT_TTL');

        if ($validator->fails()) {
            return response()->json( [
                'error_message' => $validator->errors(),
                'result' => 'error'
            ], 422);
        }
        if (! $token = auth()->setTTL($ttl)->attempt($validator->validated())) {
            return response()->json([
                'result' => 'error',
                'error_message' => 'Unauthorized'
            ], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:user',
            'password' => 'required|string|confirmed|min:6',
            'permission' => 'integer',
        ]);
        if($validator->fails()){
            return response()->json(
                [
                    'error_message' => $validator->errors(),
                    'result' => 'error'
                ], 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'result' => 'User successfully registered',
            'error_message' => null,
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json([
            'result' => 'User successfully signed out',
            'error_message' => null
        ]);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(
            [
                'result' => 'Success',
                'error_message' => null,
                'user_profile' => auth()->user()
            ]
        );
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'result' => 'Success',
            'error_message' => null,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()* 1
        ]);
    }
}