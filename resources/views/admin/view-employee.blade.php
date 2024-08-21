@extends('master')
@section('content')

<div class="card" style="width: 100%;">
    <div class="card-header">
        Employee Details
    </div>
    <div class="card-body">
        <h5 class="card-title">Employee ID: {{ $employee->emp_id }}</h5>
    </div><!-- Button to Open the Modal -->


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
                    <form id="generatePayslipForm"  action="{{ route('payslips.store') }}" method="post" enctype="multipart/form-data">
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
                            <label for="weeks" class="form-label">{{ __('Weeks') }} <small
                                    class="text-info">{{ __('Base salary multiplied by weeks') }}</small></label>
                            <input type="number" id="weeks" name="weeks" class="form-control" />
                        </div>

                        <div id="hourlyFields" class="mb-3" style="display: none;">
                            <small
                                class="text-info">{{ __('Attendance Date Range to use for hours calculation') }}</small>
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
                                    <option value="{{ $employee->id ?? '' }}">
                                        {{ $employee->emp_id ?? '' }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="employee" class="form-label">{{ __('Use NHIF') }}</label>
                            <select name="employee" id="employee" class="form-select">
                                <option value="">{{ __('Please select') }}</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="employee" class="form-label">{{ __('Use NSSF') }}</label>
                            <select name="employee" id="employee" class="form-select">
                                <option value="">{{ __('Please select') }}</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="use_allowance" name="use_allowance"
                                    class="form-check-input" />
                                <label for="use_allowance" class="form-check-label">{{ __('Use Allowance?') }}</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="use_deductions" name="use_deductions"
                                    class="form-check-input" />
                                <label for="use_deductions" class="form-check-label">{{ __('Use Deductions?') }}</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">{{ __('Generate payslip') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        Last updated: {{ now() }}
    </div>
</div>
<div id="payslipCard" class="card">
    <div class="card-header">
        Payslip Details
    </div>
    <div class="card-body">
        <h5 class="card-title">Employee: {{ $payslip->employee->fullname ?? 'N/A' }}</h5>
        <p class="card-text"><strong>Payslip Type:</strong> {{ ucfirst($payslip->type) }}</p>
        @if($payslip->type === 'contract')
            <p class="card-text"><strong>Title:</strong> {{ $payslip->title }}</p>
        @elseif($payslip->type === 'weekly')
            <p class="card-text"><strong>Weeks:</strong> {{ $payslip->weeks }}</p>
        @elseif($payslip->type === 'hourly')
            <p class="card-text"><strong>From Date:</strong> {{ $payslip->from_date }}</p>
            <p class="card-text"><strong>To Date:</strong> {{ $payslip->to_date }}</p>
        @endif
        <p class="card-text"><strong>Date:</strong> {{ $payslip->payslip_date }}</p>
        <p class="card-text"><strong>Use NHIF:</strong> {{ $payslip->use_nhif ? 'Yes' : 'No' }}</p>
        <p class="card-text"><strong>Use NSSF:</strong> {{ $payslip->use_nssf ? 'Yes' : 'No' }}</p>
        <p class="card-text"><strong>Use Allowance:</strong> {{ $payslip->use_allowance ? 'Yes' : 'No' }}</p>
        <p class="card-text"><strong>Use Deductions:</strong> {{ $payslip->use_deductions ? 'Yes' : 'No' }}</p>
    </div>
    <div class="card-footer text-muted">
        Generated on: {{ $payslip->created_at->format('Y-m-d') }}
    </div>
</div>



@endsection