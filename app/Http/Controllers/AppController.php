<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use App\Models\User;

class AppController extends Controller
{
    /*
        login
    */
    public function login(Request $request){
        if ($request->session()->exists('ACCOUNT_LOGIN')) {
            return redirect()->back();
        }else{
            return view('layouts.login', ['errors' => '']);
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */

    public function accountLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        if ($validator->fails()) {
            return view('layouts.login', ['errors' => 'Email hoặc password không hợp lệ!']);
        }
        $login = $request->only(['email', 'password']);
        if (Auth::attempt($login)) {
            $user = Auth::user();
            $login['name'] = $user->name;
            $login['phone'] = $user->phone;
            $request->session()->put('ACCOUNT_INFO', $login);
            return redirect()->route('homepage');
        }

        return view('layouts.login', ['errors' => 'Email hoặc password không hợp lệ!']);

    }

    /**
     * @return Application|Factory|View
     */
    public function registration()
    {
        return view('layouts.registration',['errors' => '']);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function customRegistration(Request $request): Factory|View|Application|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            're_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return view('layouts.registration', ['errors' => $validator->errors()->first()]);
        }
        $data = $request->all();
        if ($data['password'] != $data['re_password']){
            return view('layouts.registration', ['errors' => 'Re-entered password does not match']);
        }
        $this->create($data);
        return view('layouts.login', ['registration' => 'account created successfully, please login!']);
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function signOut(Request $request): \Illuminate\Http\RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
