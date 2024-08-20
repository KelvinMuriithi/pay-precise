<?php

namespace App\Http\Controllers;
use App\Enums\UserType;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $this->data['pageTitle'] = __('Dashboard');
        if(auth()->user()->type === UserType::EMPLOYEE)
        {
            return view('employee-dashboard',$this->data);
        }
       
        $employees = User::where('type', UserType::EMPLOYEE)->get();

        

        
        //attendances
        $absentees = User::where('type', UserType::EMPLOYEE)->whereDoesntHave('attendances', function($query){
            return $query->whereDay('created_at', Carbon::today())->take(1);
        })->get();

        $this->data['absentees'] = $absentees;
        $this->data['thisMonthTotalEmployees'] = User::where('type', UserType::EMPLOYEE)->whereMonth('created_at', Carbon::now())->count() ?? 0;
        $this->data['prevMonthTotalEmployees'] = User::where('type', UserType::EMPLOYEE)->whereMonth('created_at', Carbon::now()->subMonth(1))->count() ?? 0;
        $this->data['employees'] = (!empty($employees) && $employees->count() > 0) ? $employees: null;
        return view('dashboard', $this->data);
    }
}

