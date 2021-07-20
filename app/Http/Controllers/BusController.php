<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Bus;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $buses = Bus::all();
        return view('buses.index', compact('buses'));
        
    }

    public function see(){
        $bus= Http::get("http://e-traffic.taichung.gov.tw/DataAPI/api/BusDynamicAPI/300?direction=0");
        return view ('buses',);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('buses.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([ 
            'number'=>'required', 
            'road'=>'required', 
        ]);
        $id= $request->number;//公車號碼
        $id2=$request->road;//公車路程(去程:0 回程:1)
        $input=Http::get("http://e-traffic.taichung.gov.tw/DataAPI/api/BusDynamicAPI/{$id}?direction={$id2}");
        $inner=$input['Dynamic'];

        $myString = implode(',', array_column($inner, 'PlateNumb'));
        // * 更新對應欄位
        $bus = new Bus([ 
            'number' => $request->get('number'), 
            'road' => $request->get('road'), 
            'Dynamic'=>$myString,

        ]); 
        
        $bus->save(); 
        return redirect('/buses')->with('success', '景點OK！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $bus = Bus::find($id); 
        return view('edit', compact('bus'));
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
        //
        $request->validate([ 
            'number'=>'required', 
            'road'=>'required', 
        ]);
        $bn= $request->number;//公車號碼
        $br=$request->road;//公車路程(去程:0 回程:1)
        $input=Http::get("http://e-traffic.taichung.gov.tw/DataAPI/api/BusDynamicAPI/{$bn}?direction={$br}");
        $bus = Bus::find($id);
        $bus->number = $request->get('number');
        $bus->road = $request->get('road');
        $bus->Dynamic=$input;
        $bus->save(); 
        return redirect('/buses')->with('success', 'Bus updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $bus = Bus::find($id);
        $bus->delete();
        return redirect('/buses')->with('success', 'Bus deleted!');
    }
}
