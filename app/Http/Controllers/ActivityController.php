<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DataTables;
class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $API_REST;
    public $USER_ID;
    public  $USER_TOKEN;

    function __construct() {
        $this->API_REST = env('API_REST',null);
        $this->USER_ID = get_cookie('USER-ID');
        $this->USER_TOKEN =get_cookie('USER-TOKEN');
    }

    public function index(Request $request)
    {
        
        $activities = $this->listActivities($request);
        if($request && $request->ajax()){
            return $activities;
        }
        return view('activities.index');
       
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
         ->post("$this->API_REST/activities", [
            'user_id' =>$this->USER_ID,
            'name' => $request->name
        ]);
        return response()->json($response->json(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Http::withToken( $this->USER_TOKEN)
        ->accept('application/json')
        ->get("$this->API_REST/activities/$id");
        return $response ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Http::withToken( $this->USER_TOKEN)
         ->accept('application/json')
         ->put("$this->API_REST/activities/$id", [
            'name' => $request->name
        ]);
        return response()->json($response->json(), 201);
    }

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
         ->delete("$this->API_REST/activities/$id");
        return response()->json($response->json(), 201);
    }

    public function listActivities($request=null)
    {
        $response = Http::withToken( $this->USER_TOKEN)->accept('application/json')->get("$this->API_REST/activities", [
            'user_id' =>$this->USER_ID
        ]);
        $activities = $response->json();
        return ["data"=> $activities] ;
    }
}
