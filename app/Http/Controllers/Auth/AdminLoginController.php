<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class AdminLoginController extends Controller
{
    
	public function __construct()

	{

		$this->middleware('guest:admin', ['except' =>['login','logout']]);

	}

	public function showLoginForm()

	{

		return view('admin.login');

	}

	public function login(Request $request)

	{

		$this->validate($request, [

			'email' => 'required|email',

			'password' => 'required|min:6'

			]);

		if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))

		{

			return redirect(route('admin.index'));

		}

			return redirect('admin.login')->withInput($request->only('email', 'remember'));

	}


	    public function logout()
    {

        Auth::guard('admin')->logout();

        return redirect('/');

    }

}
