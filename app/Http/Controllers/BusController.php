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
        //用Http::get方式去呼叫API得到資料存入變數input

        /*  $myString 代表車號 ;
            $myString1 代表時間;
            $myString2 代表X座標;
            $myString3 代表Y座標; */

        if($input=="null"){//API回傳資料為null
            $myString = "null";
            $myString1 = "null";
            $myString2 = "null";
            $myString3 = "null";
        }else{
            $inner=$input['Dynamic'];//將API回傳資料中的Dynamic陣列資料存入inner變數
            $myString = implode(',', array_column($inner, 'PlateNumb'));//將inner陣列中多筆PlateNumb資料用逗號隔開，並將資料存入mySting變數
            $myString1 = implode(',', array_column($inner, 'GPS_Time'));
            $myString2 = implode(',', array_column($inner, 'X'));
            $myString3 = implode(',', array_column($inner, 'Y'));
            //方法參考網址:https://stackoverflow.com/questions/36134258/laravel-array-to-string-conversion/36134350
        }

        // * 更新對應欄位
        $bus = new Bus([ 
            'number' => $request->get('number'), 
            'road' => $request->get('road'), 
            'PlateNumb'=>$myString,
            'GPS_Time'=>$myString1,
            'X'=>$myString2,
            'Y'=>$myString3,

        ]); 
        
        $bus->save(); 
        return redirect('/buses')->with('success', '資料已完成!');
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
        if($input=="null"){//API回傳資料為null
            $myString = "null";
            $myString1 = "null";
            $myString2 = "null";
            $myString3 = "null";
        }else{
            $inner=$input['Dynamic'];//將API回傳資料中的Dynamic陣列資料存入inner變數
            $myString = implode(',', array_column($inner, 'PlateNumb'));//將inner陣列中多筆PlateNumb資料用逗號隔開，並將資料存入mySting變數
            $myString1 = implode(',', array_column($inner, 'GPS_Time'));
            $myString2 = implode(',', array_column($inner, 'X'));
            $myString3 = implode(',', array_column($inner, 'Y'));
            //方法參考網址:https://stackoverflow.com/questions/36134258/laravel-array-to-string-conversion/36134350
        }
        
        $bus = Bus::find($id);//找到需要更新的資料id
        $bus->number = $request->get('number');
        $bus->road = $request->get('road');
        $bus->PlateNumb=$myString;
        $bus->GPS_Time=$myString1;
        $bus->X=$myString2;
        $bus->Y=$myString3;
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
