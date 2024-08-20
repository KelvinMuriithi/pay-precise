@extends('master')
@section('title', 'Employee List')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<!-- Button to Open the Modal -->
<div class="container mt-4">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payslipModal">
        {{ __('Add New Payslip') }}
    </button>
</div>

<!-- Modal for Adding Payslip -->
<!-- Modal -->
<div class="modal fade" id="payslipModal" tabindex="-1" aria-labelledby="payslipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payslipModalLabel">Add Payslip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('payslips.store') }}" method="post" enctype="multipart/form-data">
          @csrf     
          <div class="mb-3">
            <label for="type" class="form-label">{{ __('Type') }}</label>
            <select name="type" id="type" class="form-select">
              <option value="">{{ __('Select Payslip Type') }}</option>
              <option value="hourly">{{ __('Hourly') }}</option>
              <option value="contract">{{ __('Contract') }}</option>
              <option value="monthly">{{ __('Monthly') }}</option>
              <option value="weekly">{{ __('Weekly') }}</option>
            </select>
          </div>

          <div id="contractFields" class="mb-3" style="display: none;">
            <label for="title" class="form-label">{{ __('Payslip Title') }}</label>
            <input type="text" id="title" name="title" class="form-control" />
          </div>

          <div id="weeklyFields" class="mb-3" style="display: none;">
            <label for="weeks" class="form-label">{{ __('Weeks') }} <small class="text-info">{{ __('Base salary multiplied by weeks') }}</small></label>
            <input type="number" id="weeks" name="weeks" class="form-control" />
          </div>

          <div id="hourlyFields" class="mb-3" style="display: none;">
            <small class="text-info">{{ __('Attendance Date Range to use for hours calculation') }}</small>
            <div class="mb-3">
              <label for="from_date" class="form-label">{{ __('From Date') }}</label>
              <input type="text" id="from_date" name="from_date" class="form-control datepicker" />
            </div>
            <div class="mb-3">
              <label for="to_date" class="form-label">{{ __('To Date') }}</label>
              <input type="text" id="to_date" name="to_date" class="form-control datepicker" />
            </div>
          </div>

          <div class="mb-3">
            <label for="payslip_date" class="form-label">{{ __('Date') }}</label>
            <input type="date" id="payslip_date" name="payslip_date" class="form-control datepicker" />
          </div>

          <div class="mb-3">
            <label for="employee" class="form-label">{{ __('Employee') }}</label>
            <select name="employee" id="employee" class="form-select">
              <option value="">{{ __('Select Employee') }}</option>
              @foreach ($employees as $employee)
                <option value="{{ $employee->employeeDetail->id ?? '' }}">{{ $employee->fullname ?? '' }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input type="checkbox" id="use_allowance" name="use_allowance" class="form-check-input" />
              <label for="use_allowance" class="form-check-label">{{ __('Use Allowance?') }}</label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input type="checkbox" id="use_deductions" name="use_deductions" class="form-check-input" />
              <label for="use_deductions" class="form-check-label">{{ __('Use Deductions?') }}</label>
            </div>
          </div>

          <div class="mb-3">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Payslip ID</th>
                        <th>Employee ID</th>
                        <th>Type</th>
                        <th>Net pay</th>
                        <th>Start date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Payslip ID</th>
                        <th>Employee ID</th>
                        <th>Type</th>
                        <th>Net pay</th>
                        <th>Start date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($payslips as $payslip)
                    <tr>
                        <td>{{ $payslip->ps_id }}</td>
                        <td>{{ $payslip->employeeDetail->emp_id??'N/A' }}</td> <!-- Adjust as necessary -->
                        <td>{{ $payslip->type }}</td>
                        <td>{{ number_format($payslip->net_pay, 2) }}</td>
                        <td>{{ $payslip->created_at->format('d-m-Y') }}</td> <!-- Adjust date format as necessary -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection