<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    /**
     * @group Authenticate
     *
     * Register
     *
     * @bodyParam username required string
     * @bodyParam name required string
     * @bodyParam email required string
     * @bodyParam password required string
     *
     * @responseFile 200 responses/register-200.json
     * @responseFile 422 responses/register-422.json
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        $user = $this->create($data);
        event(new Registered($user));

        $credentials = $request->all(['email', 'password']);
        $token = auth('api')->attempt($credentials);

        return response()->json([
            'message' => 'User is registered successfully',
            'token'   => $token,
            'type'    => 'bearer',
            'expires' => auth('api')->factory()->getTTL() * 60, // time to expiration
        ]);
    }




    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'activation_code' => $this->getActivationCode(),
        ]);
        auth()->guard()->login($user);

        return $user;
    }


    protected function getActivationCode()
    {
        return time().hash_hmac('sha256', Str::random(20), config('activation.key'));
    }

}
