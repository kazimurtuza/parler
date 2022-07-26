<!DOCTYPE html>
<html lang="en">
@include('admin.partials._head')
<body data-theme-version="light">
@include('admin.partials._preloader')

<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper" class="{{ (isset($common_data->sidebar_menu) && ($common_data->sidebar_menu == 'collapse'))?'menu-toggle':'' }} {{ (isset($common_data->sidebar_menu) && ($common_data->sidebar_menu == 'hide'))?'hide-menu':'' }}">
    @include('admin.partials._nav_header')

    @include('admin.partials._chatbox')

    @include('admin.partials._header')

    @include('admin.partials._sidebar')


    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            {{--<div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    @if(isset($common_data->page_title))
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $common_data->page_title }}</a></li>
                    @endif
                </ol>
            </div>--}}

            @yield('main_content')
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->


        @include('admin.partials._footer')
    <!--**********************************
       Support ticket button start
    ***********************************-->

    <!--**********************************
       Support ticket button end
    ***********************************-->
    @yield('page_modals')

</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
@include('admin.partials._scripts')




</body>
</html>
