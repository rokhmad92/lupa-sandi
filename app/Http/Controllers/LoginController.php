<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'Login'
        ]);
    }

    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt($validateData)) {
            return 'Berhasil Login!';
        } else {
            return back();
        }
    }

    public function registerView()
    {
        return view('register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $user = New User;
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return back();
    }

    public function forgotView()
    {
        return view('forgot', [
            'title' => 'Lupa sandi'
        ]);
    }

    public function sendEmail(Request $request)
    {
        $validateData = $request->input('email');

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $validateData,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $action_link = route('show.reset.password', ['token'=>$token, 'email'=>$request->input('email')]);
        $body = "Kami Menerima Laporan Bahwa Email " . $request->input('email') . " Lupa Kata Sandi";

        Mail::send('email',['action_link'=>$action_link, 'body'=>$body], function($messege) use ($request) {
            $messege->from('admin@abdataccounting.com', 'Abdata Accounting');
            $messege->to($request->input('email'))
                    ->subject('reset Password');
        });

        return back();
    }


    public function showResetPassword(Request $request, $token = null)
    {
        return view('reset')->with(['token'=>$token, 'email'=>$request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password_confirmation' => 'required',
            'password' => 'required|confirmed'
        ]);

        $check_token = DB::table('password_resets')->where([
            'email' => $request->input('email'),
            'token' => $request->input('token')
        ])->first();

        if(!$check_token){
            return redirect('/');
        } else {
            User::where('email', $request->input('email'))->update([
                'password' => Hash::make($request->input('password'))
            ]);

            DB::table('password_resets')->where('email', $request->input('email'))->delete();

            return redirect('/');
        }
    }
}
