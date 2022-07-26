@extends('admin.auth.layout')

@section('main_content')
    <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <h4 class="text-center mb-4">Sign in your account</h4>
                    <form action="{{ route('auth.login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-1"><strong>Email</strong></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                            @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="mb-1"><strong>Password</strong></label>
                            <div class="input-group mb-3 password-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                <button class="btn group-btn" onclick="togglePassword(this, '#password')" type="button">
                                    <i class="fa fa-eye-slash"></i>
                                </button>
                            </div>
                            @if($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mt-4 mb-2">
                            <div class="mb-3">
                                <div class="form-check custom-checkbox ms-1">
                                    <input type="checkbox" class="form-check-input" name="remember" value="1" id="basic_checkbox_1">
                                    <label class="form-check-label" for="basic_checkbox_1">Remember me</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary ">Sign Me In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')

@endsection
