<?php


if (!function_exists('getHotelID')) {
    /**
     * Get the Site Name of the Site/Client append URI and Value
     *
     *
     * @return string
     */
    function getHotelID()
    {
        $client_id = app('request')->has('client_id') ? app('request')->get('client_id') : null;
        $client_secret = app('request')->has('client_secret') ? app('request')->get('client_secret') : null;
        if($client_id && $client_secret){
            $hotel = DB::table('oauth_clients')->where('id',$client_id)->where('secret',$client_secret)->first();
            $hotel_id = $hotel ? $hotel->hotel_id : null;
            return $hotel_id;
        }
        return false;       
    }

    function getOutletID()
    {
        $client_id = app('request')->has('client_id') ? app('request')->get('client_id') : null;
        $client_secret = app('request')->has('client_secret') ? app('request')->get('client_secret') : null;
        
        if($client_id && $client_secret){
            $outlet = DB::table('oauth_clients')->where('id',$client_id)->where('secret',$client_secret)->first();
            $outlet_id = $outlet ? $outlet->outlet_id : null;
            return $outlet_id;
        }
        return false;       
    }

    function getUserFromApiToken(){

        $client_id = app('request')->has('client_id') ? app('request')->get('client_id') : null;
        $client_secret = app('request')->has('client_secret') ? app('request')->get('client_secret') : null;
        $api_token = app('request')->header('Authorization') ? app('request')->header('Authorization') : null;

        $user = array();
        if($client_id && $client_secret && $api_token){
            $user = DB::table('users')->where('api_token',$api_token)->first();
            return $user;
        }
        return false;       

    }

}
