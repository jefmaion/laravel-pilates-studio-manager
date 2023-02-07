<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    

    public function responseJSON($data) {
        return response()->json($data);
    }

    public function responseRedirect($url,  $message=null, $type='success') {
        Session::flash($type, $message);
        return redirect()->to($url);
    }




    public function toSelectBox($objects, $key, $value)  {

        $options= [];

        foreach($objects as $item) {
            $options[$item->{$key}] = $item->{$value};
        }

        return $options;


    }
    

}
