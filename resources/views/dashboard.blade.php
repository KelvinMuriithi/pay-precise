@extends('master')



@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
            </li>
        </ol>
        <h1>{{ __('Welcome') }} {{ !empty(auth()->user()->username) ? auth()->user()->username . '!' : '' }}</h1>
    </nav>
    <!-- /Page Header -->

    <!-- Superadmin Section -->
    <div class="row">



        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <span class="h1"><i class="fa-solid fa-user"></i></span>
                    <h3>{{ !empty($employees) ? $employees->count() : 0 }}</h3>
                    <p>{{ __('Employees') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('New Employees') }}</h4>
                        <h3>{{ $thisMonthTotalEmployees }}</h3>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 70%;"></div>
                        </div>
                        <p>{{ __('Previous Month Employees') }} {{ $prevMonthTotalEmployees }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-lg-6 col-xl-4 d-flex">
    <div class="card flex-fill">
        <div class="card-body">
            <h4 class="card-title">{{ __('Today Absent') }} <span
                    class="badge bg-danger">{{ $absentees->count() }}</span></h4>
            @foreach ($absentees as $user)
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="mb-0">{{ $user->fullname }}</p>
                    </div>
                </div>
            @endforeach     
            @can('view-attendances')
                <div class="text-center mt-3">
                    <a class="text-dark" href="{{ route('attendances.index') }}">{{ __('Load More') }}</a>
                </div>
            @endcan
        </div>
    </div>
</div>

@endsection