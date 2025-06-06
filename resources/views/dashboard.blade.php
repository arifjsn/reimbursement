@extends('templates.main')

@section('title')
Dashboard
@endsection

@section('body')

<div class="card-body">

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-auto">
            @if(auth()->user()->hasRole('Admin'))
                <a href="{{ route('admin.reimbursement.index') }}">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('dist/img/reimbursement.png') }}" alt="Reimbursement">
                        <div class="card-body">
                            <p class="card-text fw-bold">Reimbursement</p>
                        </div>
                    </div>
                </a>
            @else
                <a href="{{ route('reimbursement.index') }}">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('dist/img/reimbursement.png') }}" alt="Reimbursement">
                        <div class="card-body">
                            <p class="card-text fw-bold">Reimbursement</p>
                        </div>
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>

@endsection