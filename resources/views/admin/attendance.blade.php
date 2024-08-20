@extends('master')
@section('title', 'Employee List')
@section('content')

<div class="content container-fluid">
    <!-- Page Header -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Attendance List') }}
            </li>
        </ol>
        <h1>{{ __('Attendances') }}</h1>
    </nav>
    <!-- /Page Header -->

    <!-- Search Filter -->
    <form action="" method="get">
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{ __('Employee Name') }}</label>
                    <input type="text" name="employee" value="{{ request()->employee }}" class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{ __('Select Month') }}</label>
                    <select name="month" class="form-select">
                        <option value=""> - </option>
                        <option value="01" {{ request()->month == '01' ? 'selected' : '' }}>{{ __('Jan') }}</option>
                        <option value="02" {{ request()->month == '02' ? 'selected' : '' }}>{{ __('Feb') }}</option>
                        <option value="03" {{ request()->month == '03' ? 'selected' : '' }}>{{ __('Mar') }}</option>
                        <option value="04" {{ request()->month == '04' ? 'selected' : '' }}>{{ __('Apr') }}</option>
                        <option value="05" {{ request()->month == '05' ? 'selected' : '' }}>{{ __('May') }}</option>
                        <option value="06" {{ request()->month == '06' ? 'selected' : '' }}>{{ __('Jun') }}</option>
                        <option value="07" {{ request()->month == '07' ? 'selected' : '' }}>{{ __('Jul') }}</option>
                        <option value="08" {{ request()->month == '08' ? 'selected' : '' }}>{{ __('Aug') }}</option>
                        <option value="09" {{ request()->month == '09' ? 'selected' : '' }}>{{ __('Sep') }}</option>
                        <option value="10" {{ request()->month == '10' ? 'selected' : '' }}>{{ __('Oct') }}</option>
                        <option value="11" {{ request()->month == '11' ? 'selected' : '' }}>{{ __('Nov') }}</option>
                        <option value="12" {{ request()->month == '12' ? 'selected' : '' }}>{{ __('Dec') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{ __('Select Year') }}</label>
                    <select name="year" class="form-select">
                        <option value=""> - </option>
                        @foreach ($years_range as $year)
                            <option value="{{ $year->year }}" {{ request()->year == $year->year ? 'selected' : '' }}>
                                {{ $year->year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">{{ __('Search') }}</button>
                </div>
            </div>
        </div>
    </form>
    <!-- /Search Filter -->

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Employee') }}</th>
                            @for ($day = 1; $day <= $days_in_month; $day++)
                                <th>{{ $day }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employees))
                                            @foreach ($employees as $employee)
                                                                <tr>
                                                                    <td>
                                                                        <!-- @php
                                                                            $link = route('admin.employees.show', ['employee' => Crypt::encrypt($employee->id)]);
                                                                        @endphp -->
                                                                        <a href="#" class="d-flex align-items-center">
                                                                            <span>{{ $employee->fullname }}</span>
                                                                        </a>
                                                                    </td>
                                                                    @for ($day = 1; $day <= $days_in_month; $day++)
                                                                                        @php
                                                                                            $currentMonth = request()->month ?? now()->month;
                                                                                            $year = request()->year ?? now()->year;
                                                                                            $attendance = $employee->attendances()
                                                                                                ->whereDay('created_at', $day)
                                                                                                ->whereMonth('created_at', $currentMonth)
                                                                                                ->whereYear('created_at', $year)
                                                                                                ->first();
                                                                                        @endphp
                                                                                        <td>
                                                                                            @if (!empty($attendance->startDate) && !empty($attendance->endDate))
                                                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                                                    data-bs-target="#attendanceDetailsModal"
                                                                                                    data-url="{{ route('attendance.details', $attendance->id) }}">
                                                                                                    Present
                                                                                                </a>
                                                                                            @else
                                                                                                Absent
                                                                                            @endif
                                                                                        </td>
                                                                    @endfor
                                                                </tr>
                                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection