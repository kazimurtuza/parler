@extends('admin.auth.layout')

@section('main_content')
    <div class="authincation-content">
        <div class="row no-gutters">
            <div class="col-xl-12">
                <div class="auth-form">
                    <h4 class="text-center mb-4">Account Locked</h4>
                    <form action="{{ route('admin.index') }}">
                        <div class="text-center mb-4">
                            <div class="header-right">
                                <div class="header-profile">
                                    <div class="nav-link">
                                        <img src="{{ asset('assets/backend/images/profile/pic1.jpg') }}" alt="">
                                        <div class="header-info ms-3">
                                            <span>John Doe</span>
                                            <small>Superadmin</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label><strong>Password</strong></label>
                            <div class="input-group mb-3 password-group">
                                <input type="password" id="password" class="form-control" placeholder="Password">
                                <button class="btn group-btn" onclick="togglePassword(this, '#password')" type="button">
                                    <i class="fa fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary ">Unlock</button>
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
