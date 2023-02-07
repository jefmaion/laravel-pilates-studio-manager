<?php

/** Render a blade component */

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

if(!function_exists('component')) {
    function component($component) {
        return $component->render()->with($component->data())->render();
    }
}

if(!function_exists('USD_BRL')) {
    function USD_BRL($value) {
        return number_format($value, 2, ",", ".");
    }
}

if(!function_exists('BRL_USD')) {
    function BRL_USD($value) {
        return str_replace(",", ".", str_replace(".", "", $value));
    }
}


if(!function_exists('responseJSON')) {
    function responseJSON($data) {
        return response()->json($data);
    }
}

if(!function_exists('responseRedirect')) {
    function responseRedirect($route, $message=null, $type='success') {

        if($message) {
            Session::flash($type, $message);
        }

        if(is_array($route)) {
            return redirect()->route($route[0], $route[1]);
        }
        
        return redirect()->route($route);
    }
}


if(!function_exists('appConfig')) {
    function appConfig($key) {
        if($conf = Config::get('application.'.$key)) {
            return $conf;
        }
        
        return null;
    }
}


if(!function_exists('responseToDataTable')) {
    function responseToDataTable($data) {
        return responseJSON(['data' => $data]);
    }
}

if(!function_exists('requestData')) {
    function requestData(FormRequest $request) {
        return $request->except(['_token', '_method']);
    }
}


if(!function_exists('imageProfile')) {
    
    function imageProfile($image=null) {

        $default = 'assets/img/users/user-1.png';

        if(empty($image)) {
            return asset($default);
        }

        if(file_exists(public_path() . '/profiles/' . $image)) {
            return asset('/profiles/' . $image);
        }

        return asset($default);
    }
}

if(!function_exists('dateExt')) {
    function dateExt($date) {


        $w = date('w', strtotime($date));
        $m = date('n', strtotime($date));
        $y = date('Y', strtotime($date));


        $monthName = Config::get('application.monthNames')[$m];
        $weekdayName = Config::get('application.weekdays')[$w];

        

        return $weekdayName.', ' . date('j', strtotime($date)) . ' de ' . $monthName . ' de ' .$y;

    }
}