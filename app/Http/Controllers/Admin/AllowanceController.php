<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeAllowance;
use App\Models\EmployeeDeduction;
use App\Models\User;

class AllowanceController extends Controller
{
    public function index()
    {
        $pageTitle = __('Allowances');
        $employees = User::with('employeeDetail')->get();
        $allowances = EmployeeAllowance::get();
        $deductions = EmployeeDeduction::get();
        return view('admin.allowance-deductions',compact(
            'allowances',
            'pageTitle',
            'employees',
            'deductions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::where('type', UserType::EMPLOYEE)
            ->whereHas('employeeDetail')
            ->where('is_active', true)->get();
        return view("pages.payroll.allowances.create",compact(
            'employees'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        EmployeeAllowance::create([
            'employee_detail_id' => $request->employee, 
            'name' => $request->name,
            'amount' => $request->amount, 
        ]);
        $notification = notify(__('Allowance has been added'));
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeAllowance $allowance)
    {
        $employees = User::where('type', UserType::EMPLOYEE)
            ->whereHas('employeeDetail')
            ->where('is_active', true)->get();
        return view("pages.payroll.allowances.edit",compact(
            'employees','allowance'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeAllowance $allowance)
    {
        $allowance->update([
            'employee_detail_id' => $request->employee ?? $allowance->employee_detail_id, 
            'name' => $request->name ?? $allowance->name,
            'amount' => $request->amount ?? $allowance->amount, 
        ]);
        $notification = notify(__('Allowance has been updated'));
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAllowance $allowance)
    {
        $allowance->delete();
        $notification = notify(__('Allowance has been deleted'));
        return back()->with($notification);
    }
}
