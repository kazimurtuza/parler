

<!--**********************************
        Sidebar start
    ***********************************-->
<div class="navbar-close"></div>
<div class="deznav">
    <div class="deznav-scroll">

        <a href="{{ route('admin.pos') }}" target="_blank" class="add-menu-sidebar">
            <i class="fas fa-laptop"></i>
            <span class="nav-text">POS </span>
        </a>

        <ul class="metismenu" id="menu">
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.index') }}" aria-expanded="false">
                        {{--<i class="flaticon-025-dashboard"></i>--}}
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('admin'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.branch.index') }}" aria-expanded="false">
                        {{--<i class="flaticon-025-dashboard"></i>--}}
                        <i class="fas fa-code-branch"></i>
                        <span class="nav-text">Branch</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.employee.index') }}" aria-expanded="false">
                        <i class="fas fa-user-friends"></i>
                        <span class="nav-text">Employee</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('admin'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.customermember.index') }}" aria-expanded="false">
                        <i class="fas fa-credit-card"></i>
                        <span class="nav-text">Membership</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.customer.index') }}" aria-expanded="false">

                        <i class="fa fa-address-book"></i>
                        <span class="nav-text">Customer</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.service.index') }}" aria-expanded="false">
                        <i class="fas fa-broom"></i>
                        <span class="nav-text">Service</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.branch_service.index') }}" aria-expanded="false">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Branch Service</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.product.index') }}" aria-expanded="false">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="nav-text">Product</span>
                    </a>
                </li>
            @endif
            @if(checkUserRole('manager'))
                <li>
                    <a class="ai-icon" href="{{ route('admin.invoice.index') }}" aria-expanded="false">
                        <i class="fa fa-file-invoice"></i>
                        <span class="nav-text">Invoice</span>
                    </a>
                </li>
            @endif


            @if(checkUserRole('manager'))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="far fa-hand-paper"></i>
                        <span class="nav-text">Requisition</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.productrequisition.add') }}">New</a></li>
                        <li><a href="{{ route('admin.requisition.type',0) }}">Pending</a></li>
                        <li><a href="{{ route('admin.requisition.type',1) }}">Approved</a></li>
                        <li><a href="{{ route('admin.requisition.type',2) }}">Rejected</a></li>
                        <li><a href="{{ route('admin.requisition.type',3) }}">Purchased</a></li>
                    </ul>
                </li>
            @endif

            @if(checkUserRole('storekeeper'))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-store"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.product.use')}}">Use Products</a></li>
                        <li><a href="{{route('admin.availableProduct')}}">Available Product</a></li>
                    </ul>
                </li>
            @endif

            @if(checkUserRole('manager'))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-chart-pie"></i>
                        <span class="nav-text">Account</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.bank-account.index')}}">Bank Accounts</a></li>
                        <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Expenses</a>
                            <ul aria-expanded="false">
                                @if(checkUserRole('manager'))
                                    <li><a href="{{route('admin.expense.index')}}">Expense</a></li>
                                @endif
                                @if(checkUserRole('admin'))
                                    <li><a href="{{route('admin.expenseCategory.index')}}">Category</a></li>
                                    <li><a href="{{route('admin.expenseSubcategory.index')}}">Subcategory</a></li>
                                @endif
                            </ul>
                        </li>

                    </ul>
                </li>
            @endif

            @if(checkUserRole('manager'))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-chart-bar"></i>
                        <span class="nav-text">Report</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.sale-report.index')}}">Sale Report</a></li>
                        <li><a href="{{route('admin.employee-report.index')}}">Employee Report</a></li>
                        <li><a href="{{route('admin.membership-report.index','all')}}">Membership Report</a></li>
                        <li><a href="{{route('admin.ledger-report.index','all')}}">Ledger</a></li>


                    </ul>
                </li>
            @endif

                @if(checkUserRole('manager'))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-chart-bar"></i>
                        <span class="nav-text">Setting</span>
                    </a>
                    <ul aria-expanded="false">

                        <li><a href="{{route('admin.vat.index')}}">vat Setting</a></li>


                    </ul>
                </li>
            @endif


        </ul>

        <div class="plus-box">
            <p class="fs-16 font-w500 mb-1">Need Any Help? Please Contact Our Support Team.</p>
{{--            <a class="btn rsbtn-2 mt-3" href="https://www.retinasoft.com.bd/" target="_blank"><i class="las la-long-arrow-alt-right"></i></a>--}}
            <div class="rsbtn-2 mt-2">
                <span class="rsbtn-2_circle">
                </span>
                <a class="rsbtn-2_inner" href="https://www.retinasoft.com.bd/" target="_blank">
                      <span class="button_text_container">
                        Contact
                      </span>
                </a>
            </div>
        </div>
        <div class="copyright">
            <p class="fs-14 font-w200">
                <strong class="font-w400 text-black">Company Name </strong>
                <br>
                © 2022 All Rights Reserved
            </p>
            <p>Developed By <strong class=""><a href="https://www.retinasoft.com.bd/" class="text-black" target="_blank">Retina Soft</a></strong></p>
            <p>Version: 1.0</p>
        </div>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->
