<?php

namespace App\Http\Controllers;

use App\Models\mf_Company;
use App\Http\Requests\Storemf_CompanyRequest;
use App\Http\Requests\Updatemf_CompanyRequest;
use App\Models\Car;
use App\Models\Command;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MfCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        return $this->middleware('auth:sanctum')->except('index');
    }
    public function index()
    {
        //
        if(isset($_GET['type']) && $_GET['type'] == 'archive'){
            $companies = mf_Company::whereNotNull('deleted_at')->withTrashed()->paginate(10);
            foreach($companies as $company){
                $company->setAttribute('path','/Brande/edit/'.$company->slug);
            }
            // send states data for cards of statics
            $carsCount = Car::get()->count();
            $usersCount = User::get()->count();
            $CommandCount = Command::get()->count();
            $stateData = ['CarsCount'=> $carsCount,'usersCount'=> $usersCount,'CommandCount'=>$CommandCount];
            return response()->json(['data'=>$companies,'statsData'=>$stateData ]);
        }elseif(isset($_GET['type']) && $_GET['type'] == 'indexdata'){
            $companies = mf_Company::all();
            return response()->json(['data'=>$companies ]);
        }else{
            $companies = mf_Company::latest()->paginate(10);
            foreach($companies as $company){
                $company->setAttribute('path','/Brande/edit/'.$company->slug);
            }
             // send states data for cards of statics
            $carsCount = Car::get()->count();
            $usersCount = User::get()->count();
            $CommandCount = Command::get()->count();
            $stateData = ['CarsCount'=> $carsCount,'usersCount'=> $usersCount,'CommandCount'=>$CommandCount];
            return response()->json(['data'=>$companies,'statsData'=>$stateData ]);
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
     * @param  \App\Http\Requests\StoreMarqueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storemf_CompanyRequest $request)
    {
        //

        $imgae_name  = '';

        $data =json_decode($request->data,true);
        $rules = [
            'title'=> 'required|unique:mf__companies,title',
        ];
        // validate data objet using Validator class
        $v = Validator::make($data, $rules);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()->all(),'message'=>$v->errors()->first()], 422);
        }else{

            if($request->hasFile('file')){
                $upload_path = public_path('images/Brandes');
                $imgae_name = '/images/Brandes/'. time(). $request->file->getClientOriginalName();
                $new_name =  time(). $request->file->getClientOriginalName();
                $request->file->move($upload_path,$new_name);

            }
            mf_Company::create([
                'title'=>$data['title'],
                'slug'=>Str::slug($data['title']),
                 'logo'=>$imgae_name

            ]);
            return response()->json(['message' =>'The new Company  Added SuccessFully']);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $company = mf_Company::where('slug',$slug)->first();
        return response()->json(['data'=>$company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function edit(mf_Company $marque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarqueRequest  $request
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function update(Updatemf_CompanyRequest $request, $slug)
    {
        //
        $upload_path = public_path('images/Brandes');
        $company = mf_Company::where('slug',$slug)->first();
        $data =json_decode($request->data,true);
        $rules = [
            'title'=> 'required|unique:mf__companies,title,'.$company->id,
        ];
        // validate data objet using Validator class
        $v = Validator::make($data, $rules);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()->all(),'message'=>$v->errors()->first()], 422);
        }else{
            if($request->hasFile('file')){
                $image_path = $company->logo;
                if(File::exists($image_path)){
                    unlink($image_path);
                }
                $company->logo = '/images/Brandes/'. time(). $request->file->getClientOriginalName();
                $new_name =  time(). $request->file->getClientOriginalName();
                $request->file->move($upload_path,$new_name);

            }
            $company->update([
                'title'=>$data['title'],
                'slug'=>Str::slug($data['title']),
                'logo'=>$company->logo
            ]);
            return response()->json(['message'=>'The company Data Updated SuccessFully']);

        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
        $company = mf_Company::where('slug',$slug)->withTrashed()->first();
        if(!empty($company->deleted_at)){
          // if this brande was archived i will active it
          $company->deleted_at = null;
          $company->save();
          return response()->json(['message'=>'Comany '.$slug.' Actived  Succseccfully']);
        }else{
            // archive rande and delete brande image
            $image_path = $company->logo;
            if(File::exists($image_path)){
                unlink($image_path);
            }
            $company->delete();
            $company->save();
            return response()->json(['message'=>'Comany '.$slug.' Deleted  Succseccfully']);
        }

    }
}
