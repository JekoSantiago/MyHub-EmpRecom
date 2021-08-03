@php use App\Helper\MyHelper; @endphp
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{{route('home')}}">
                        <i data-feather="home"></i>
                        <span> Home </span>
                    </a>
                </li>
                @php $checkAccessParams['userAccess'] = Session::get('UserAccess');
                     $checkAccessParams['moduleID'] = env('MODULE_PEA');
                @endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_VIEW')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_EDIT')] || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ADD')]) )  )
                <li>
                    <a href="#sidebarPEA" data-toggle="collapse" aria-expanded="false" >
                        <i class="mdi mdi-briefcase-check-outline"></i>
                        <span class="menu-collapsed"> PEA</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse sidebar-submenu" id="sidebarPEA" style="">
                        <ul class="nav-second-level">
                            @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ADD')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_EDIT')]))
                            <li>
                                <a href="{{route('PEA_Filed')}}" class="menu-collapsed">In-process</a>
                            </li>
                            @endif
                            @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_APPROVE')]) )
                            <li>
                                <a href="{{route('PEA_Approval')}}" class="menu-collapsed">Approval</a>
                            </li>
                            @endif
                            @if(MyHelper::decrypt(Session::get('Department_ID')) == env('HR_DEPT_ID'))
                            <li>
                                <a href="#" class="menu-collapsed">Reports</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @php
                    $checkAccessParams['moduleID'] = env('MODULE_PARS');
                @endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_VIEW')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_EDIT')] || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ADD')]) )  )
                <li>
                    <a href="#sidebarRFNSP" data-toggle="collapse" aria-expanded="false" >
                        <i data-feather="shield"></i>
                        <span class="menu-collapsed"> PARS - RF & NSP</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse sidebar-submenu" id="sidebarRFNSP" style="">
                        <ul class="nav-second-level">
                            <li>
                                <a href="#" class="menu-collapsed">In-process</a>
                            </li>
                            <li>
                                <a href="#" class="menu-collapsed">Approval</a>
                            </li>
                            <li>
                                <a href="#" class="menu-collapsed">Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @php
                $checkAccessParams['moduleID'] = env('MODULE_PARSL');
                @endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_VIEW')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_EDIT')] || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ADD')]) )  )
                <li>
                    <a href="#sidebarLeaders" data-toggle="collapse" aria-expanded="false" >
                        <i data-feather="award"></i>
                        <span class="menu-collapsed">PARS - Leaders</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse sidebar-submenu" id="sidebarLeaders" style="">
                        <ul class="nav-second-level">
                            <li>
                                <a href="#" class="menu-collapsed">In-process</a>
                            </li>
                            <li>
                                <a href="#" class="menu-collapsed">Approval</a>
                            </li>
                            <li>
                                <a href="#" class="menu-collapsed">Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @php
                $checkAccessParams['moduleID'] = env('MODULE_BI');
                @endphp
                @if(MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ALL')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_VIEW')]) || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_EDIT')] || MyHelper::checkUserAccess($checkAccessParams,[env('APP_ACTION_ADD')]) )  )
                <li>
                    <a href="#sidebarBI" data-toggle="collapse" aria-expanded="false" >
                        <i class="mdi mdi-magnify"></i>
                        <span class="menu-collapsed"> BI</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse sidebar-submenu" id="sidebarBI" style="">
                        <ul class="nav-second-level">
                            <li>
                                <a href="#" class="menu-collapsed">In-process</a>
                            </li>
                            <li>
                                <a href="#" class="menu-collapsed">Approval</a>
                            </li>
                            <li>
                                <a href="#" class="menu-collapsed">Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <li>
                    <a href="#">
                        <i data-feather="user-check"></i>
                        <span> NPA Approval </span>
                    </a>
                </li>


                <li>
                    <a href="#">
                        <i data-feather="user-x"></i>
                        <span> Non Reg Approval </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i data-feather="user"></i>
                        <span> Probationary Employees </span>
                    </a>
                </li>


            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
