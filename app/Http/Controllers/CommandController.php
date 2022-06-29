<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Command;
use App\Models\mf_Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCommandRequest;
use App\Http\Requests\UpdateCommandRequest;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $commands = Command::latest()->with('user','car')->paginate(10);
        $CompaniesCount = mf_Company::get()->count();
        $usersCount = User::get()->count();
        $carsCount = Car::get()->count();
        $stateData = ['CompaniesCount'=> $CompaniesCount,'usersCount'=> $usersCount,'carsCount'=>$carsCount];
        return response()->json(['data'=>$commands,'statsData'=>$stateData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommandRequest $request)
    {
        //

        $data =json_decode($request->data,true);
        $rules = [
            'car_id'=>'required',
            'dateL'=>'required|date',
            'dateR'=>'required|date',
            'PrixTTC'=>'required',
            'notes'=>'nullable',
        ];
        // validate data objet using Validator class
        $v = Validator::make($data, $rules);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()->all(),'message'=>$v->errors()->first()], 422);
        }else{
        $Car = Car::where('id',$data['car_id'])->first();
        $Car->dispo = 0;
        $Car->save();
        Command::create([
            'user_id'=>auth('sanctum')->user()->id,
            'car_id'=>$data['car_id'],
            'dateL'=>$data['dateL'],
            'dateR'=>$data['dateR'],
            'PrixTTC'=>$data['PrixTTC'],
            'notes'=>'',

        ]);

        return response()->json(['message'=>'Booking Done Successfully']);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function show(Command $command)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function edit(Command $command)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommandRequest  $request
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommandRequest $request, Command $command)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $command = Command::where('id',$id)->first();
        $car = Car::where('id',$command->car_id)->first();
        $car->dispo=1;
        $car->save();
        $command->delete();
        return response()->json(['message'=>'Command Deleted']);


    }
}
