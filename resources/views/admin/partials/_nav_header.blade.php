<!--**********************************
        Nav header start
    ***********************************-->
<div class="nav-header">
    <a href="{{ route('admin.index') }}" class="brand-logo">
        <img src="{{ asset('logo/icon.png') }}" class="logo-abbr">
        <img src="{{ asset('logo/logo.png') }}" class="brand-title hide-dark">
        <img src="{{ asset('logo/logo-white.png') }}" class="brand-title show-dark">
    </a>
    <div class="nav-control">
        <div class="hamburger {{ (isset($common_data->sidebar_menu) && ($common_data->sidebar_menu == 'collapse'))?'is-active':'' }}">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->
