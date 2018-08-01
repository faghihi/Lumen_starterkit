<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as Controller;

class ApiAuthController extends Controller
{
    use Helpers;
    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['register', 'login']]);
    }

    /**
     * Register a user and get a JWT.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::query()->create([
            'email' => $request['email'],
            'password' => app('hash')->make($request->get('password'))
        ]);

        try {
            if (! $token = $this->guard()->attempt($credentials)) {
                return response()->json(['error' => ['message' => 'Unauthorized','status_code' => '401']], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return $this->respondWithToken($token);

    }

    /**
     * login the user and get a JWT.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email'=>'required|email',
            'password' => 'required|min:6',
        ]);

        try {
            if (! $token = $this->guard()->attempt($credentials)) {
                $user = User::query()->where('email', $request->input('email'))->first();
                if (!$user) {
                    return response()->json(['error' => ['message' => 'Email does not exist.','status_code' => '401']], 401);
                }
                else{
                    return response()->json(['error' => ['message' => 'Password is wrong','status_code' => '401']], 401);
                }
            }
        } catch (JWTException $e) {
            return response()->json(['error' => ['message' => 'could_not_create_token','status_code' => '500']], 500);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['data' => ['message' => 'Successfully logged out','status_code' => '200']], 200);
    }

    /**
     * user reset password.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6',
        ]);

        if($user = app('Dingo\Api\Auth\Auth')->user()){

            $credentials = [
                'email' => $user->email,
                'password' => $request['password']
            ];

            try {
                if (! $token = $this->guard()->attempt($credentials)) {
                    return response()->json(['error' => ['message' => 'Password is wrong','status_code' => '401']], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => ['message' => 'could_not_create_token','status_code' => '500']], 500);
            }

            $user->password = app('hash')->make($request->get('new_password'));
            $user->save();

            return $this->respondWithToken($token);
        }
        else{
            return response()->json(['error' => ['message' => 'Unauthorized','status_code' => '401']], 401);
        }
    }


    /**
     * user forgot password and get a JWT.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $credentials = $this->validate($request, [
            'email'=>'required|email',
        ]);

        try {
            if (! $token = $this->guard()->attempt($credentials)) {
                $user = User::query()->where('email', $request->input('email'))->first();
                if (!$user) {
                    return response()->json(['error' => ['message' => 'Email does not exist.','status_code' => '401']], 401);
                }
                else{
                    return response()->json(['error' => ['message' => 'Password is wrong','status_code' => '401']], 401);
                }
            }
        } catch (JWTException $e) {
            return response()->json(['error' => ['message' => 'could_not_create_token','status_code' => '500']], 500);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'result' => 1,
            'message' => 'Login Successfully',
            'token' => $token,
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

}