<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminAuthentication;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function showLoginForm(){
        return View('front-end.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // dinh nghia lai ham login
    protected function authenticated(Request $request, $user)
    {
        $date_now = date('Y-m-d h:i:s');
        if($user->attempt > 2){ // dung nhung attempt qua 3 lan
            if(strtotime($user->last_access) < strtotime($date_now) &&  strtotime($date_now) < (strtotime($user->last_access) + 10)){
                $messa = "Tài khoản của bạn bị khóa trong 30 phút ";
                echo "<script type='text/javascript'>alert('$messa');</script>";
                Auth::logout();
                return redirect('login');
            }
            else { // het thoi gian khoa
                User::where('email' , '=', $user->email)->update(['attempt' => 0, 'last_access' => $date_now]);
                return redirect('/');
            }
        }
        else { // dung va attempt chua toi 3 lan
                    User::where('email' , '=', $user->email)->update(['attempt' => 0, 'last_access' => $date_now]);
                    return redirect('/');
            }

         // neu login sai
         if(Auth::login($user, false))
         {
             dd("cum");
            $attempt = $user->attempt + 1;
            User::where('email' , '=', $user->email)->update(['attempt' => $attempt, 'last_access' => $date_now]);
         }

    }
}
