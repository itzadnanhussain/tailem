<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password_confirmation' => 'required',
            'password' => ['required', Rules\Password::defaults()]
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => "error", 'message' => $validation->errors()->first()]);
        } else {
            ///post data to database
            $post = array();
            $post['user_name'] = $request->user_name;
            $post['email'] = $request->email;
            $post['password'] = $request->password;
            $insert_id = addNew('users', $post);
            if ($insert_id) {
                ///set session
                $request->session()->put('user_id', $insert_id);

                $response = array("code" => 'success', 'message' => 'You are registered successfully!');
                return response()->json($response);
            }
        }
    }
    // public function store(Request $request)
    // {
    //     // echo '<pre>';
    //     // print_r($request->all());
    //     // echo '</pre>';
    //     // die;
    //     $request->validate([
    //         'user_name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => ['required', 'password', Rules\Password::defaults()],
    //     ]);
 
    //     $user = User::create([
    //         'user_name' => $request->user_name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]); 
    //     event(new Registered($user)); 
    //     Auth::login($user);

    //   return redirect(RouteServiceProvider::HOME);
    // }
}
