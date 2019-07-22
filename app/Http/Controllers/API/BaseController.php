<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status'  => 200
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [])
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'status'  => 200
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response);
    }

    public function sendResponseWithBaseURL($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status'  => 200,
            'bseurl'  => asset('storage/app/public/media/')
        ];


        return response()->json($response, 200);
    }
}