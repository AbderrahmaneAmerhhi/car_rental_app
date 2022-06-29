<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Command;
use App\Models\Marque;
use App\Models\mf_Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth:sanctum')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(isset($_GET['type']) && $_GET['type'] == 'archive'){
            $Cars = Car::with('Company')->whereNotNull('deleted_at')->withTrashed()->paginate(10);

            $CompaniesCount = mf_Company::get()->count();
            $usersCount = User::get()->count();
            $CommandCount = Command::get()->count();
            $stateData = ['CompaniesCount'=> $CompaniesCount,'usersCount'=> $usersCount,'CommandCount'=>$CommandCount];
            return response()->json(['data'=>$Cars,'statsData'=>$stateData ]);
        }elseif(isset($_GET['type']) && $_GET['type'] == 'indexdata'){
            if(isset($_GET['cmpid'])){
                $Cars = Car::with('Company')->where('dispo',1)->where('company_id',$_GET['cmpid'])->latest()->paginate(6);
            }else{
                $Cars = Car::with('Company')->where('dispo',1)->latest()->paginate(6);
            }

            return response()->json(['data'=>$Cars ]);
        }else{
            $Cars = Car::with('Company')->latest()->paginate(10);

            $CompaniesCount = mf_Company::get()->count();
            $usersCount = User::get()->count();
            $CommandCount = Command::get()->count();
            $stateData = ['CompaniesCount'=> $CompaniesCount,'usersCount'=> $usersCount,'CommandCount'=>$CommandCount];
            return response()->json(['data'=>$Cars,'statsData'=>$stateData ]);
        }

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
     * @param  \App\Http\Requests\StoreCarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request)
    {
        //
        $imgae_name  = '';

        $data =json_decode($request->data,true);
        $rules = [
            'Brande'=> 'required|unique:cars,Brande',
            'company_id'=> 'required',
            'type'=> 'required|String',
            'prixJ'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'dispo'=>'required',
        ];
        // validate data objet using Validator class
        $v = Validator::make($data, $rules);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()->all(),'message'=>$v->errors()->first()], 422);
        }else{

            if($request->hasFile('file')){
                $upload_path = public_path('images/Cars');
                $imgae_name = '/images/Cars/'. time(). $request->file->getClientOriginalName();
                $new_name =  time(). $request->file->getClientOriginalName();
                $request->file->move($upload_path,$new_name);

            }
            Car::create([
                'Brande'=>$data['Brande'],
                'slug'=>Str::slug($data['Brande']),
                'type'=>$data['type'],
                'prixJ'=>$data['prixJ'],
                'dispo'=>$data['dispo'],
                'company_id'=>$data['company_id'],
                 'image'=>$imgae_name

            ]);
            return response()->json(['message' =>'Car Added SuccessFully']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $car = Car::where('slug',$slug)->first();
        return response()->json(['data'=>$car]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarRequest  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarRequest $request, $slug)
    {
        //
        $upload_path = public_path('images/Cars');
        $car = Car::where('slug',$slug)->first();
        $data =json_decode($request->data,true);
        $rules = [
            'Brande'=> 'required|unique:cars,Brande,'.$car->id,
            'company_id'=> 'required',
            'type'=> 'required|String',
            'prixJ'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'dispo'=>'required',
        ];
        // validate data objet using Validator class
        $v = Validator::make($data, $rules);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()->all(),'message'=>$v->errors()->first()], 422);
        }else{
            if($request->hasFile('file')){
                $image_path = $car->image;
                if(File::exists($image_path)){
                    unlink($image_path);
                }
                $car->image = '/images/Cars/'. time(). $request->file->getClientOriginalName();
                $new_name =  time(). $request->file->getClientOriginalName();
                $request->file->move($upload_path,$new_name);

            }
            $car->update([
                'Brande'=>$data['Brande'],
                'slug'=>Str::slug($data['Brande']),
                'type'=>$data['type'],
                'prixJ'=>$data['prixJ'],
                'dispo'=>$data['dispo'],
                'company_id'=>$data['company_id'],
                'image'=>$car->image
            ]);
            return response()->json(['message'=>'Car Updated SuccessFully']);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
        $car = Car::where('slug',$slug)->withTrashed()->first();
        if(!empty($car->deleted_at)){
          // if this car was archived i will active it
          $car->deleted_at = null;
          $car->dispo = 1;
          $car->save();
          return response()->json(['message'=>'Car '.$slug.' Actived  Succseccfully']);
        }else{
            // archive car and delete car image
            $image_path = $car->logo;
            if(File::exists($image_path)){
                unlink($image_path);
            }
            $car->dispo = 0;
            $car->delete();
            $car->save();
            return response()->json(['message'=>'Car '.$slug.' Deleted  Succseccfully']);
        }
    }
}
