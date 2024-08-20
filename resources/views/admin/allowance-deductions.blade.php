@extends('master')

@section('content')
<div class="container">
    <h1>{{ $pageTitle }}</h1>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="allowances-tab" data-toggle="tab" href="#allowances" role="tab" aria-controls="allowances" aria-selected="true">Allowances</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="deductions-tab" data-toggle="tab" href="#deductions" role="tab" aria-controls="deductions" aria-selected="false">Deductions</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Allowances Tab -->
        <div class="tab-pane fade show active" id="allowances" role="tabpanel" aria-labelledby="allowances-tab">
            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addAllowanceModal">Add Allowance</button>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allowances as $allowance)
                    <tr>
                        <td>{{ $allowance->name }}</td>
                        <td>${{ number_format($allowance->amount, 2) }}</td>
                        <td>
                            <a href="{{ route('allowances.edit', $allowance->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('allowances.destroy', $allowance->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Deductions Tab -->
        <div class="tab-pane fade" id="deductions" role="tabpanel" aria-labelledby="deductions-tab">
            <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addDeductionModal">Add Deduction</button>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deductions as $deduction)
                    <tr>
                       <td>{{ $deduction->name }}</td>
                        <td>${{ number_format($deduction->amount, 2) }}</td>
                        <td>
                            <a href="{{ route('deductions.edit', $deduction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('deductions.destroy', $deduction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Allowance Modal -->
<div class="modal fade" id="addAllowanceModal" tabindex="-1" role="dialog" aria-labelledby="addAllowanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAllowanceModalLabel">Add Allowance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('allowances.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="employee">Select Employee</label>
                        <select name="employee" id="employee" class="form-control">
                            <option value="">--Please select--</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->employeeDetail->id??'No id' }}">{{ $employee->firstname }} {{ $employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Allowance Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Allowance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Deduction Modal -->
<div class="modal fade" id="addDeductionModal" tabindex="-1" role="dialog" aria-labelledby="addDeductionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeductionModalLabel">Add Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('deductions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="employee">Select Employee</label>
                        <select name="employee" id="employee" class="form-control">
                            <option value="">--Please select--</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->employeeDetail->id??'No id' }}">{{ $employee->firstname }} {{ $employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Deduction Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Deduction</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
