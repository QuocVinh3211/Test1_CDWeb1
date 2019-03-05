<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Hash;

class LoginController extends Controller
{

     // chuc nang login
     public function authenticate(Request $request)
     {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
         // du lieu nhap vao
        $email = $request->email;
        $password = $request->password;
        $date_now = date('Y-m-d h:i:s');
         $getUser = User::where('email', '=' , $email)->first();

        //  $checkLogin = DB::table('users')->where([
        //     ['email'    , '=' , $email],
        //     ['password' , '=' , $newpass],
        //     ])->get();

        if(isset($getUser))
        {
           $attempt = $getUser->attempt;   
           $last_access = $getUser->last_access;
        }
        else {
           
           // $attempt = $attempt + 1;
           // User::where('email' , '=', $email)->update(['attempt' => $attempt, 'last_access' => $date_now]);
            dd("sai mk");
        }
        // neu dang nhap thanh cong
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            if($attempt > 2){ // dung nhung attempt qua 3 lan
                  if(strtotime($last_access) < strtotime($date_now) &&  strtotime($date_now) < (strtotime($last_access) + 1800)){
                      $messa = "Tài khoản của bạn bị khóa trong 30 phút ";
                      echo "<script type='text/javascript'>alert('$messa');</script>";
                      dd("khoa 3 phut");
                       Auth::logout();
                      return redirect('login');
                    //   dd("dang nhap qua 3 lan, dang trong thoi gian khoa");
                  }
                  else { // het thoi gian khoa
                      User::where('email' , '=', $email)->update(['attempt' => 0, 'last_access' => $date_now]);
                      return redirect('/');
                    //   dd("qua 3 lan, nhung het thoi gian khoa");
                  }
              }
              else { // attempt chua toi 3 lan
                  User::where('email' , '=', $email)->update(['attempt' => 0, 'last_access' => $date_now]);
                   return redirect('/'); 
                 //dd("dang nhap dung, nhung sai chua qua 3 lan");
              }
        }
        else {
            if($attempt > 2)
            {
                $messa = "Tài khoản của bạn bị khóa trong 30 phút ";
                echo "<script type='text/javascript'>alert('$messa');</script>";
                dd("nhap sai 3 lan roi nha che");
            }
            else {
                $attempt = $attempt + 1;
                User::where('email' , '=', $email)->update(['attempt' => $attempt, 'last_access' => $date_now]);
                dd("dung email sai mk");
            }
           
        }
     }
}



//  echo "thanh cong roi" . $date_now;
//  var_dump($user);

//  else {
//     echo "dang nhap that bai";
// }