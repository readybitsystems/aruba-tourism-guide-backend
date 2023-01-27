<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\Tour;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function appData(Request $request)
    {
        $currentStamp = time();
        $update_data = (date("Y-m-d h:m:s", $request->timestamp));
        // $update_data = (date("Y-m-d", $t)); //TODO: IF NEED
        // $country = Country::where('updated_at','>=', $update_data)->orderBy('created_at', 'desc')->with('tours.places.placeImages')->get();
        $countries = Country::where('updated_at','>=', $update_data ?? 0)->orderBy('created_at', 'desc')->get();
        $tours = Tour::where('updated_at','>=', $update_data ?? 0)->orderBy('created_at', 'desc')->get();
        $places = Place::where('updated_at','>=', $update_data ?? 0)->orderBy('created_at', 'desc')->with('placeImages')->get();
        return [
            'countries' => $countries,
            'tours'=> $tours,
            'places' => $places,
            'timestamp' => $currentStamp
        ];
    }
}