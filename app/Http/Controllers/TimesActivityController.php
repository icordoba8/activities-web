<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class TimesActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $API_REST;
    public  $USER_TOKEN;

    function __construct() {
        $this->API_REST = env('API_REST',null);
        $this->USER_TOKEN =get_cookie('USER-TOKEN');
    }

    public function index()
    {
        $response = Http::withToken( $this->USER_TOKEN)
        ->accept('application/json')
        ->get("$this->API_REST/times/activity/$request->activity_id");
        return ["data"=> $response->json()] ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Http::withToken( $this->USER_TOKEN)
        ->accept('application/json')
        ->get("$this->API_REST/times/activity/$request->activity_id");
        $hours = $response['hours'];
        $sum = $hours + $request->hours;
        $messje = [];
        if($sum<=8){
            $responseSave = Http::withToken( $this->USER_TOKEN)
            ->accept('application/json')
            ->post("$this->API_REST/times",[
                'activity_id' =>$request->activity_id,
                'date_time' => $request->date_time,
                'hours' => $request->hours
            ]);
            $messje[] = $responseSave->json();
            return response()->json($messje, 201);
        };

        $messje['message'] = "Horas activida  ($sum) superan el maximo permitido 8";
        return response()->json($messje, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Http::withToken( $this->USER_TOKEN)
         ->accept('application/json')
         ->delete("$this->API_REST/times/$id");
        return response()->json($response->json(), 201);
    }
    public function timesActivity($id)
    {
        $response = Http::withToken( $this->USER_TOKEN)
        ->accept('application/json')
        ->get("$this->API_REST/times/activity/$id");
        $times = $response['times'];
        return ["data"=> $times] ;
    }

    
}
