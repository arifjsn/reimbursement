@extends('templates.main-global')

@section('title')
Login
@endsection

@section('body')
<div class="login-box">

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h3 class="mb-0"><b>Reimbursements</b></h3>
        </div>
        <div class="card-body">

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <form action="{{ route('login_submit') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control" placeholder="Email or Username" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="text-danger ml-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="text-danger ml-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row d-flex justify-content-end">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
@endsection