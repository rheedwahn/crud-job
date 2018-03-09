<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Tymon\JWTAuth\Exceptions\JWTException ;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;

use App\User;

use Auth;

use Image;

use JWTAuth;



class AuthController extends Controller

{
	// function __construct()
	// {
	// 	$this->middleware('jwt.auth')->only('hostel');
	// }

	public function home(Request $request)
	{
		return view('auth/home');
	}

	

	public function contact(Request $request)
	{
		return view('auth/contact');
	}


	public function register(Request $request)
	{
		$this->validate($request, [
			'fname'=> 'required|string',
			'email'=> 'required|email|unique:users',
			'password' => 'required|min:5',
			'course' => 'required|string',
			'matric' => 'required'
		]);
		$user = new User([ 
			'fname' => $request->input('fname'),
			'email' => $request->input('email'),
			'matric' => $request->input('matric'),
			'course' => $request->input('course'), 
			'password' => bcrypt($request->input('password')),
		]);
		$user->save();
		return response()->json([
			'message' => 'Successfully registered student !'
		], 201);
	}	

	public function login(Request $request)
	{	

		$this->validate($request, [
			'password' => 'required|min:5',
			'matric' => 'required'
		]);

		$credentials = $request->only('password','matric');
		try{
			if ( !$token = JWTAuth::attempt($credentials)) {

				return response()->json(['error' =>'Invalid credentials !'], 401);
			}
		}catch(JWTException $e){

			return response()->json(['error' =>'Could not create token!'], 500);
		}
		return response()->json([
			'token'=> $token
		], 200);
	}

// this where i want to display the details 
	public function hostel()
	{	
		return view('auth/hostel');
		
	}

	public function refresh()
	{
		return response([
			'status' => 'success'
		]);
	}

// this is my endpoint where the details are fetched from
	public function getUser(Request $request, $matric, $column=['matric'])
		{		

			$matric = $request->matric;
			$user = DB::table('users')->where('matric', $matric)->first();

			return ['user' => $user];	
		}


	public function logout()
	{
		JWTAuth::invalidate();
		return response([
			'status' => 'success',
			'msg' => 'Logged out Successfully.'
		], 200);
	}
}
