<?php

namespace App\Http\Controllers;

use App\Mail\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        if($request->input('password') === $request->input('confirm_password') ){
            $data = $request->validate([
                'email' => 'required|email',
                'password'=> 'required|min:8|max:25',
                'name'=> 'required|min:10|max:255'
            ]);
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = Hash::make($data['password']);
    $user->save();

//Send confirmation mail-uncomment below code to receive mail notification after registration.

 $toEmail = $data['email'];
 $subject3 = "Welcome to SparePark";
 $name3 = $data['name'];
 Mail::to($toEmail)->send(new Register($subject3, $name3 ));


    //Login
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $credentials = $request->only('email', 'password');
    $remember = $request->filled('remember');
    if(Auth::attempt($credentials, $remember)){
    return redirect()->intended('/')->with('success', 'Registration successful');
    }else{
        return redirect()->route('main')->with('error', 'Login failed');
    }
        }
   else{
    return redirect()->route('register.create')->with('error', 'Password does not match');
   }

   //Send email
   

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
