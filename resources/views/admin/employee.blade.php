@extends('master')
@section('title', 'Employee List')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- employee details form -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add New Employee
</button>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.employees.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" id="firstname" name="firstname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="middlename" class="form-label">{{ __('Middle Name') }}</label>
                                <input type="text" class="form-control" id="middlename" name="middlename">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" id="lastname" name="lastname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">{{ __('UserName') }}</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation"
                                    class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department" class="form-label">{{ __('Department') }}</label>
                                <select name="department" id="department" class="form-select">
                                    @if (!empty($departments))
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="designation" class="form-label">{{ __('Designation') }}</label>
                                <select name="designation" id="designation" class="form-select">
                                    @if (!empty($designations))
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status">
                                <label class="form-check-label" for="status">{{ __('Status') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- end employee detail -->

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Employees List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Employee ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Employee ID</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->firstname }} {{ $employee->lastname }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->employeeDetail->emp_id ?? '' }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <!-- Button to trigger the modal for updating salary -->
                                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#salaryModal{{ $employee->id }}">
                                        Update Salary
                                    </button>

                                    <!-- Button to trigger the modal for generating payslip -->
                                    <form
                                        action="{{ route('admin.employees.show', ['employee' => \Crypt::encrypt($employee->id)]) }}"
                                        method="get" style="display: inline;">
                                        <button type="submit" class="btn btn-primary">
                                            View Profile
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="salaryModal{{ $employee->id }}" tabindex="-1"
                            aria-labelledby="salaryModalLabel{{ $employee->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="salaryModalLabel{{ $employee->id }}">Edit Salary
                                            Settings for {{ $employee->firstname }} {{ $employee->lastname }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('employee.salary-setting', $employee->id) }}" method="post">
                                            @csrf('PUT')
                                            <div class="mb-3">
                                                <label for="salary_basis" class="form-label">Salary Basis</label>
                                                <select class="form-select" name="basis" id="salary_basis">
                                                    <option value="">Please select</option>
                                                    <option value="hourly">Hourly</option>
                                                    <option value="contract">Contract</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="weekly">Weekly</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="payment_type" class="form-label">Payment Type</label>
                                                <select class="form-select" name="payment_method" id="payment_type">
                                                    <option value="">Please select</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="banktransfer">Bank Transfer</option>
                                                    <option value="cash">Cash</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Salary Amount</label>
                                                <input type="number" class="form-control" id="amount" name="base_salary"
                                                    required>
                                            </div>
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection