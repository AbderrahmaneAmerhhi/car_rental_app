<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    //
    public function index(){
        $commandByMonths = DB::select('select count(id) as CommandsCount,monthname(created_at) as month from commands group by monthname(created_at) order by monthname(created_at) desc ');
         $carbycmp = DB::select('select count(*) as carscount,mf__companies.title as mfcmptitle from mf__companies  inner join cars on (cars.company_id = mf__companies.id) group by mf__companies.title  ');
        $stateData = ['commandByMonths'=> $commandByMonths,'carbycmp'=> $carbycmp ];
        return response()->json(['statsData'=>$stateData]);
    }
}
