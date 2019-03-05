<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Airways;
use App\List_cities;
use App\Flights;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Passengers;
use App\Flights_booking;
use App\Http\Requests\BookingRequest;

class FlightController extends Controller
{   
    // get list city
    public function getList()
    {
        $flight = list_cities::all();
        return view('front-end.index', ['flight' => $flight]);
    }

    // get view detail
    public function detail($flight_id, $total, $flight_class, $time_from)
    {
        $flight = DB::table('flights')->where('flight_id', '=' , $flight_id)->get();
        return View('front-end.flight-detail', ['flight' => $flight, 'flight_id' => $flight_id, 
                    'total' => $total, 'flight_class' => $flight_class, 'time_from' => $time_from]);
    }

    // get view booking
    public function booking($flight_id, $total, $flight_class, $time_from)
    {     
        if (Auth::check()) {
            $flight = DB::table('flights')->where('flight_id', '=' , $flight_id)->get();
            return View('front-end.flight-book', ['flight' => $flight, 'flight_id' => $flight_id, 
                    'total' => $total, 'flight_class' => $flight_class, 'time_from' => $time_from]);
        } else {
                return view('front-end.login');
            }              
    }

    // search
    public function getSearch(Request $res)
    {
        $from = $res->from;
        $to   = $res->to;
        //dd($from . $to);
        // cau truy van search             
        $users = DB::table('flights')->where([
            ['flight_city_from_id', '=', $from],
            ['flight_city_to_id', '=', $to],
        ])->get();
        return view('front-end.flight-list', ['search'=> $users]);
    }

    // book flights
    public function postBooking(Request $res){
    
       // add Passengers
       $passenger = new Passengers();
       $passenger->passenger_title       = $res->passenger_title;
       $passenger->passenger_first_name  = $res->firstName;
       $passenger->passenger_last_name   = $res->lastName;
       $passenger->passenger_user_id     = $res->flight_id;
       $passenger->passenger_fl_id       = $res->user_id;
       $passenger->save();

       // add booking-flight
       $book = new Flights_booking();
       $book->user_id        = $res->user_id;
       $book->flight_id      = $res->flight_id;
       $book->total_price    = $res->total_price;
       $book->Payment_Method = $res->payment;
       $book->card_number    = $res->card_number;
       $book->card_name      = $res->card_name;
       $book->ccv_code       = $res->ccv_code;
       $book->save();

       return redirect()->route('/');
    }
}
