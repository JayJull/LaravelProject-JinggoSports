@extends('master.master1')
@section('title', 'Create Data')
@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="row justify-content-center w-50">
        <div class="col-md-8"> <!-- Adjust the column width as needed -->
            <div class="panel panel-default">
                <div class="panel-heading text-center">Reset Password</div>
                <div class="panel-body p-4"> <!-- Add padding for better spacing -->
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form1" method="post" action="{{ route('verifikasi', ['token' => $token]) }}" id="login-form">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="password">Password</label>
                            <div class="col-md-8"> <!-- Adjust width to make input wider -->
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-8"> <!-- Adjust width to make input wider -->
                                <input type="password" class="form-control" name="confirm-password">
                                @error('confirm password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-md-offset-4"> <!-- Adjust width and offset for better alignment -->
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
