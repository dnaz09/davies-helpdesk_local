<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DPPI | HELPDESK</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="/assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">    
    

    <link href="/assets/css/animate.css" rel="stylesheet">    
    <link href="/assets/css/jquery.filer.css" rel="stylesheet">    
    <link href="/assets/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet">
    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/assets/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">       
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/assets/bootstrap-multiselect-0.9.13/css/bootstrap-multiselect.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <link href="/assets/css/styleowa.css" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
        ]) !!};
    </script>
</head>
<body>
    <?php $routeUri = Route::currentRouteName();?>
    <?php $user = Auth::user(); ?>
    <?php $imgURL = (!$user->image ? 'default.jpg' : $user->image); ?>       
    <?php 
        use App\User;   
        $superiors = User::getSupId();
    ?>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                            <span>
                                <?php 
                                if(!empty($user->image)){
                                    ?>{!! Html::image('/uploads/users/'.$user->employee_number.'/'.$imgURL,'',['class'=>'img-circle','style'=>'width:50px; height:50px;']) !!}
                                <?php }
                                else{
                                    ?><img alt="image" class="img-circle" src="/uploads/users/default.jpg" style="width:50px; height:50px;" />
                                 <?php }
                                 ?>
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{!! strtoupper($user->first_name.' '.$user->last_name) !!}</strong>
                                 </span> <span class="text-muted text-xs block">{!! strtoupper($user->position) !!}<b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">                                        
                                <li><a href="../../user/reset/password.php">Change Password</a></li>                                                
                                <li class="divider"></li>
                                <li>{!! Html::decode(link_to_route('logout', '<i class="fa fa-sign-out"></i> Log out',array(), ['class' => 'large button'])) !!}</li>   
                            </ul>
                        </div>                        
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>                
                    <li class="<?php echo ($routeUri=='dashboard') ? 'active' : '' ?>">{!! Html::decode(link_to_route('dashboard.index', '
                        <i class="fa fa-dashboard fa-2x"></i>
                        <span class="nav-label">Dashboard</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-gears fa-2x"></i> <span class="nav-label">My Account</span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="../../user/reset/password.php"> <i class="fa fa-wrench fa-1x"></i> Change Password</a>
                            </li>
                            <!-- <li>
                                <a href="../../user/reset/password.php"> <i class="fa fa-wrench fa-1x"></i> Change Username</a>
                            </li> -->
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file fa-2x"></i> <span class="nav-label">FORMS </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php echo ($routeUri=='files') ? 'active' : '' ?>">{!! Html::decode(link_to_route('files.index', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">Downloadable Files</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>
                    </li>
                    @if($user->role_id === 4)
                    <li>
                        <a href="#"><i class="fa fa-building fa-2x"></i> <span class="nav-label">MANAGER</span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php echo ($routeUri=='mng_work_authorization') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mng_work_authorization.mng_work_authorization_list', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">Work Authorization Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='mng_obp') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mng_obp.mng_obp_list', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">OBF Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if($user->superior === 0)
                    <li>
                        <a href="#"><i class="fa fa-building fa-2x"></i> <span class="nav-label">SUPERIOR</span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php echo ($routeUri=='mngr_obp') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mngr_obp.mngr_obp_list', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">OBF Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='mngr_undertime') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mngr_undertime.mngr_undertime_list', '
                                <i class="fa fa-clock-o fa-1x"></i>
                                <span class="nav-label">Undertime</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='mngr_requisition') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mngr_requisition.mngr_requisition_list', '
                                <i class="fa fa-credit-card fa-1x"></i>
                                <span class="nav-label">Requisition</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='sup_work_authorization') ? 'active' : '' ?>">{!! Html::decode(link_to_route('sup_work_authorization.sup_work_authorization_list', '
                                <i class="fa fa-check-circle-o fa-1x"></i>
                                <span class="nav-label">Work Authorization</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='sup_asset_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('sup_asset_request.sup_asset_request_list', '
                                <i class="fa fa-share-square fa-1x"></i>
                                <span class="nav-label">Item Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='sup_jo_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('sup_jo_request.jo_list', '
                                <i class="fa fa-share-square fa-1x"></i>
                                <span class="nav-label">Job Order Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>                                                               
                    </li>
                    @endif 
                    @if($user->dept_id === 7 )
                    <li>
                        <a href="#"><i class="fa fa-gears fa-2x"></i> <span class="nav-label">Maintenance </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php echo ($routeUri=='item_categories/list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('item_categories.list', '
                                <i class="fa fa-play-circle-o fa-1x"></i>
                                <span class="nav-label">Item Categories</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='maintenance/files') ? 'active' : '' ?>">{!! Html::decode(link_to_route('files.itindex', '
                                <i class="fa fa-play-circle-o fa-1x"></i>
                                <span class="nav-label">File Maintenance</span>', array(), ['class' => 'large button'])) !!}
                            </li>       
                            <li class="<?php echo ($routeUri=='roles') ? 'active' : '' ?>">{!! Html::decode(link_to_route('roles.index', '
                                <i class="fa fa-play-circle-o fa-1x"></i>
                                <span class="nav-label">Role</span>', array(), ['class' => 'large button'])) !!}
                            </li>        
                            <li class="<?php echo ($routeUri=='departments') ? 'active' : '' ?>">{!! Html::decode(link_to_route('departments.index', '
                                <i class="fa fa-building fa-1x"></i>
                                <span class="nav-label">Departments</span>', array(), ['class' => 'large button'])) !!}
                            </li>    
                            <li class="<?php echo ($routeUri=='locations') ? 'active' : '' ?>">{!! Html::decode(link_to_route('locations.index', '
                                <i class="fa fa-map fa-1x"></i>
                                <span class="nav-label">Locations</span>', array(), ['class' => 'large button'])) !!}
                            </li> 
                            <li class="<?php echo ($routeUri=='users') ? 'active' : '' ?>">{!! Html::decode(link_to_route('users.index', '
                                <i class="fa fa-users fa-1x"></i>
                                <span class="nav-label">Users</span>', array(), ['class' => 'large button'])) !!}
                            </li>       
                            <li class="<?php echo ($routeUri=='user_access_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('user_access_request.index', '
                                <i class="fa fa-user-plus fa-1x"></i>
                                <span class="nav-label">M-User Access Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>      
                            <li class="<?php echo ($routeUri=='supplies') ? 'active' : '' ?>">{!! Html::decode(link_to_route('supplies.index', '
                                <i class="fa fa-briefcase fa-1x"></i>
                                <span class="nav-label">M-Supplies</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='service_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('service_request.index', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">M-Service Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>          
                        </ul>
                    </li>    
                    @endif   
                    @if($user->id === 25 )   
                        <li class="<?php echo ($routeUri=='it_manager') ? 'active' : '' ?>">{!! Html::decode(link_to_route('it_manager.index', '
                            <i class="fa fa-clock-o fa-2x"></i>
                            <span class="nav-label">For Approval Request</span>', array(), ['class' => 'large button'])) !!}
                        </li>       
                    @endif
                    <li>
                        <a href="#"><i class="fa fa-laptop fa-2x"></i> <span class="nav-label">IT-HELPDESK </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">       
                            <li class=" <?php echo ($routeUri=='it_helpdesk/user_access_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('it_helpdesk.user_access_request', '
                                <i class="fa fa-unlock-alt fa-1x"></i> 
                                <span class="nav-label">User Access Request</span>', array(), ['class' => 'large button'])) !!}
                            </li> 
                            <li class="<?php echo ($routeUri=='it_helpdesk/service_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('it_helpdesk.service_request', '
                                <i class="fa fa-reply fa-1x"></i>
                                <span class="nav-label">Service Request</span>', array(), ['class' => 'large button'])) !!}
                            </li> 
                            @if($user->dept_id === 7)
                            <li class="<?php echo ($routeUri=='it_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('it_request_list.index', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">IT Request Lists</span>', array(), ['class' => 'large button'])) !!}
                            </li> 
                            @endif
                        </ul>
                    </li>
                    @if($user->id === 25 )  
                    <li>
                        <a href="#"><i class="fa fa-book fa-2x"></i> <span class="nav-label">IT REPORTS </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">   
                            <li class="<?php echo ($routeUri=='reports/it/department') ? 'active' : '' ?>">{!! Html::decode(link_to_route('reports.it', '
                                <i class="fa fa-inbox fa-1x"></i>
                                <span class="nav-label"> Reports</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>                                                               
                    </li>
                    @endif
                    @if($user->dept_id === 6 OR $user->dept_id === 1)
                    <li>
                        <a href="#"><i class="fa fa-users fa-2x"></i> <span class="nav-label">ANNOUNCEMENT </span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php echo ($routeUri=='announcements') ? 'active' : '' ?>">{!! Html::decode(link_to_route('announcements.index', '
                                <i class="fa fa-bullhorn fa-1x"></i>
                                <span class="nav-label">Announcements</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>  
                    </li>
                    @endif
                    <li>
                        <a href="#"><i class="fa fa-users fa-2x"></i> <span class="nav-label">HR DEPARTMENT </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">   
                            <!-- @if($user->dept_id === 6)
                            <li class="<?php echo ($routeUri=='announcements') ? 'active' : '' ?>">{!! Html::decode(link_to_route('announcements.index', '
                                <i class="fa fa-bullhorn fa-1x"></i>
                                <span class="nav-label">Announcement</span>', array(), ['class' => 'large button'])) !!}
                            </li>                  
                            @endif   -->
                            <li class="<?php echo ($routeUri=='obp') ? 'active' : '' ?>">{!! Html::decode(link_to_route('obp.index', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">OBF</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @if($user->dept_id === 6)
                            <li class="<?php echo ($routeUri=='hrd_obp') ? 'active' : '' ?>">{!! Html::decode(link_to_route('hrd_obp.hr_obp_list', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">HRD OBF LIST</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @endif                          
                            <li class="<?php echo ($routeUri=='requisition') ? 'active' : '' ?>">{!! Html::decode(link_to_route('requisition.index', '
                                <i class="fa fa-cube fa-1x"></i>
                                <span class="nav-label">Requisition</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @if($user->dept_id === 6)
                            <li class="<?php echo ($routeUri=='hrd_requisition') ? 'active' : '' ?>">{!! Html::decode(link_to_route('hrd_requisition.hr_requisition_list', '
                                <i class="fa fa-cubes fa-1x"></i>
                                <span class="nav-label">HRD Requisition List</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @endif 
                            <li class="<?php echo ($routeUri=='undertime') ? 'active' : '' ?>">{!! Html::decode(link_to_route('undertime.index', '
                                <i class="fa fa-clock-o fa-1x"></i>
                                <span class="nav-label">Undertime</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @if($user->dept_id === 6)
                            <li class="<?php echo ($routeUri=='hrd_undertime') ? 'active' : '' ?>">{!! Html::decode(link_to_route('hrd_undertime.hr_undertime_list', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">HRD Undertime List</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @endif 
                            <li class="<?php echo ($routeUri=='work_authorization') ? 'active' : '' ?>">{!! Html::decode(link_to_route('work_authorization.index', '
                                <i class="fa fa-check-square-o fa-1x"></i>
                                <span class="nav-label">Work Authorization</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @if($user->dept_id === 6)
                            <li class="<?php echo ($routeUri=='hrd_work_authorization') ? 'active' : '' ?>">{!! Html::decode(link_to_route('hrd_work_authorization.hr_work_authorization_list', '
                                <i class="fa fa-check-circle-o fa-1x"></i>
                                <span class="nav-label">HRD Work Authorization List</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='hrd_exit_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('hrd_exit_list.hrd_list', '
                                <i class="fa fa-sign-out fa-1x"></i>
                                <span class="nav-label">HRD Exit Pass List</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            @endif
                        </ul>
                    </li>
                    @if($user->dept_id === 6 && $user->role_id === 4)
                    <li>
                        <a href="#"><i class="fa fa-building fa-2x"></i> <span class="nav-label">HRD REPORTS</span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">
                            <!-- <li class="<?php echo ($routeUri=='work_auth_report') ? 'active' : '' ?>">{!! Html::decode(link_to_route('work_auth.report', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">Work Authorization</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='obp_request_report') ? 'active' : '' ?>">{!! Html::decode(link_to_route('obp_request.report', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">OBF Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='requisition_report') ? 'active' : '' ?>">{!! Html::decode(link_to_route('requisition.report', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">Requisition</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='undertime_reports') ? 'active' : '' ?>">{!! Html::decode(link_to_route('undertime.report', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">Undertime</span>', array(), ['class' => 'large button'])) !!}
                            </li> -->
                            <li class="<?php echo ($routeUri=='hrd_reports') ? 'active' : '' ?>">{!! Html::decode(link_to_route('hrd_reports.index', '
                                <i class="fa fa-thumbs-up fa-1x"></i>
                                <span class="nav-label">Reports</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>                                                               
                    </li>
                    @endif 
                    <li>
                        <a href="#"><i class="fa fa-user fa-2x"></i> <span class="nav-label">ADMIN DEPT </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">                               
                            <li class="<?php echo ($routeUri=='asset_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('asset_request.index', '
                                <i class="fa fa-share-square fa-1x"></i>
                                <span class="nav-label">Borrowers Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='job_order') ? 'active' : '' ?>">{!! Html::decode(link_to_route('job_order.index', '
                                <i class="fa fa-share-square fa-1x"></i>
                                <span class="nav-label">Job Order Request</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <!-- <li class="<?php echo ($routeUri=='supplies_request') ? 'active' : '' ?>">{!! Html::decode(link_to_route('supplies_request.index', '
                                <i class="fa fa-suitcase fa-1x"></i>
                                <span class="nav-label">Supplies Request</span>', array(), ['class' => 'large button'])) !!}
                            </li> -->
                            @if($user->dept_id === 1)
                            <li class="<?php echo ($routeUri=='asset_trackings') ? 'active' : '' ?>">{!! Html::decode(link_to_route('asset_trackings.index', '
                                <i class="fa fa-map fa-1x"></i>
                                <span class="nav-label">Item Tracking</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='released_assets/list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('released_assets.list', '
                                <i class="fa fa-map fa-1x"></i>
                                <span class="nav-label">Released Items</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='returned_assets/list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('returned_assets.list', '
                                <i class="fa fa-map fa-1x"></i>
                                <span class="nav-label">Returned Items</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='released_assets/list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('asset_request.lists', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">Borrowers Request List</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='job_order_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('job_order.list', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">Job Order Request List</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <!-- <li class="<?php echo ($routeUri=='supplies') ? 'active' : '' ?>">{!! Html::decode(link_to_route('supplies.index', '
                                <i class="fa fa-file fa-1x"></i>
                                <span class="nav-label">M-Supplies</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li class="<?php echo ($routeUri=='sup_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('supplies_request.all_list', '
                                <i class="fa fa-list-ul fa-1x"></i>
                                <span class="nav-label">Supplies Request List</span>', array(), ['class' => 'large button'])) !!}
                            </li> -->
                            @endif
                        </ul>
                    </li>
                    @if($user->dept_id === 1 AND $user->role_id === 4)
                    <li>
                        <a href="#"><i class="fa fa-user fa-2x"></i> <span class="nav-label">ADMIN REPORTS</span><span class="fa arrow fa-2x"></span></a> 
                        <ul class="nav nav-second-level collapse">
                            <li class="<?php echo ($routeUri=='admin_reports') ? 'active' : '' ?>">{!! Html::decode(link_to_route('admin_reports.index', '
                                <i class="fa fa-share-square fa-1x"></i>
                                <span class="nav-label">Admin Reports</span>', array(), ['class' => 'large button'])) !!}
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if($user->dept_id === 6)
                    <li class="<?php echo ($routeUri=='guard_check') ? 'active' : '' ?>">{!! Html::decode(link_to_route('guard_check.index', '
                        <i class="fa fa-check-circle fa-2x"></i>
                        <span class="nav-label">Exit Pass Checker</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    @endif 
                    <li class="<?php echo ($routeUri=='directory') ? 'active' : '' ?>">{!! Html::decode(link_to_route('directory.index', '
                        <i class="fa fa-search fa-2x"></i>
                        <span class="nav-label">Directory</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li class="<?php echo ($routeUri=='my_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('my_request_list.index', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">My Request</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li class="<?php echo ($routeUri=='tagged_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('tagged_request_list.list', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">My Tagged Request</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li class="<?php echo ($routeUri=='userasset_trackings') ? 'active' : '' ?>">{!! Html::decode(link_to_route('userasset_trackings.list', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">My Borrowed Items</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                   
                    @if(in_array($user->id, $superiors))
                    <!-- <li class="<?php echo ($routeUri=='mngr_undertime') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mngr_undertime.mngr_undertime_list', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">My Staff Undertime</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li class="<?php echo ($routeUri=='mngr_obp') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mngr_obp.mngr_obp_list', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">My Staff OBP</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li class="<?php echo ($routeUri=='mngr_requisition') ? 'active' : '' ?>">{!! Html::decode(link_to_route('mngr_requisition.mngr_requisition_list', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">My Staff Requisition</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <li class="<?php echo ($routeUri=='sup_work_authorization') ? 'active' : '' ?>">{!! Html::decode(link_to_route('sup_work_authorization.sup_work_authorization_list', '
                        <i class="fa fa-list-ul fa-2x"></i>
                        <span class="nav-label">My Staff Work Authorization</span>', array(), ['class' => 'large button'])) !!}
                    </li>  -->            
                    @endif
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom" id="app">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <!-- <form role="search" class="navbar-form-custom" action="#">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form> -->
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        @if($user->dept_id === 1)
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                ASSET REQUEST  <adminnotif-one :assetp="assetp"></adminnotif-one>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <adminmenu-one :assetpending="assetpending"></adminmenu-one>
                                <li>
                                    <a href="{{route('asset_request.lists')}}">
                                        <center>View All</center>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                PENDING ASSETS  <adminnotif-three :totalassetrp="totalassetrp"></adminnotif-three>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <adminmenu-three :assetrp="assetrp"></adminmenu-three>
                                <li>
                                    <a href="{{route('asset_request.lists')}}">
                                        <center>View All</center>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if($user->dept_id === 6)
                        <!-- OBP -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    OBF  <hrnotif-one :obp_p="obp_p"></hrnotif-one>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <hrmenu-one :pendingobps="pendingobps"></hrmenu-one>
                                    <li>
                                        <a href="{{route('hrd_obp.hr_obp_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <!-- WORK AUTH -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    Work Authorization  <hrnotif-two :workauth_p="workauth_p"></hrnotif-two>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <hrmenu-two :workauths="workauths"></hrmenu-two>
                                    <li>
                                        <a href="{{route('hrd_work_authorization.hr_work_authorization_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <!-- UNDERTIME -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    Undertime  <hrnotif-three :undertime_p="undertime_p"></hrnotif-three>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <hrmenu-three :undertimes="undertimes"></hrmenu-three>
                                    <li>
                                        <a href="{{route('hrd_undertime.hr_undertime_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <!-- REQUI -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    Requisition  <hrnotif-four :requisition_p="requisition_p"></hrnotif-four>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <hrmenu-four :reqs="reqs"></hrmenu-four>
                                    <li>
                                        <a href="{{route('hrd_requisition.hr_requisition_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <!-- EXIT PASS -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    Exit Pass  <hrnotif-five :exitpass_p="exitpass_p"></hrnotif-five>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <hrmenu-five :exitpass="exitpass"></hrmenu-five>
                                    <li>
                                        <a href="{{route('hrd_exit_list.hrd_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if($user->id === 25)
                        <!-- MAAM TIFF -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    SAP  <sapnotif :mtog="mtog"></sapnotif>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <sapmenu :saps="saps"></sapmenu>
                                    <li>
                                        <a href="{{url('it_manager')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if($user->dept_id === 7)
                        <!-- IT -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    IT Request  <itnotif :itscount="itscount"></itnotif>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <itmenu :its="its"></itmenu>
                                    <li>
                                        <a href="{{url('it_request_list_index')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li>{!! Html::decode(link_to_route('logout', '<i class="fa fa-sign-out"></i> Log out',array(), ['class' => 'large button'])) !!}</li>
                        <li>
                            <a class="right-sidebar-toggle">
                                <i class="fa fa-comments-o"></i>
                            </a>
                        </li>   
                    </ul>
                </nav>
                <div class="page-inner">
                  <div class="col-lg-12">
                    <div>
                    @section('main-body')
                  
                    @show
                      <div id="right-sidebar" class="animated">
                        <div class="sidebar-container">
                            <ul class="nav nav-tabs navs-2">
                                <li class="active"><a data-toggle="tab" href="#tab-schat">
                                    Single Chat <chatu-count :unseencount="unseencount"></chatu-count>
                                </a></li>
                                <li><a data-toggle="tab" href="#tab-gchat">
                                    Group Chat <gchatu-count :gunseencount="gunseencount"></gchatu-count>
                                </a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-schat" class="tab-pane active">
                                    <div class="sidebar-title">
                                        <h3> <i class="fa fa-comments-o"></i> Users</h3>
                                    </div>
                                    <div>
                                        <user-search></user-search>
                                        <hr>
                                        <div class="sidebar-message">
                                            <div class="userclick">
                                                <chat-user v-on:clickUser:="fetchMessages" :onlines="onlines" :user="{{Auth::user()}}" :unseen="unseen"></chat-user>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="small-chat-box fadeInRight animated small-chat-box-single">
                                    <div id="single" class="single">
                                        <div class="heading" draggable="true">
                                            <i class="fa fa-file pull-right" 
                                                data-toggle="modal" 
                                                data-target="#chatFiles">    
                                            </i>
                                            <div class="close-single" v-on:click="fetchMessages()">
                                                <to-user :to_user="to_user" :sfcount="sfcount"></to-user>
                                            </div>
                                        </div>
                                        <chat-messages :messages="messages" :user = "{{ Auth::user() }}" :to_id = "to_id" :to_user = "to_user"></chat-messages>
                                        <div class="form-chat">
                                            <button type="button" class="btn btn-info btn-sm pull-left" data-toggle="modal" data-target="#singleUploadModal"><i class="fa fa-paperclip"></i></button>
                                            <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}" :to_id="to_id"></chat-form>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-gchat" class="tab-pane">
                                    <div class="sidebar-title">
                                        <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addModal"> 
                                            Create
                                        </button>
                                        <h3>
                                            <i class="fa fa-users"></i> Group Threads
                                        </h3>
                                    </div>
                                    <div>
                                        <group-search></group-search>
                                        <hr><br>
                                        <div class="groupclick">
                                            <group-list v-on:clickGroup:="fetchGroupMessages" :groups="groups" :user="{{Auth::user()}}" :gunseen="gunseen"></group-list>
                                        </div>
                                    </div>
                                </div>
                                <div class="small-chat-box fadeInRight animated small-chat-box-group">
                                    <div id="group" class="group">
                                        <div class="heading" draggable="true">
                                            <i class="fa fa-file pull-right" 
                                                data-toggle="modal" 
                                                data-target="#groupFiles">    
                                            </i>
                                            <div class="close-group" v-on:click="fetchGroupMessages()">
                                                <to-group :to_group="to_group" :group_id:="group_id" :fcount="fcount"></to-group>
                                            </div>
                                        </div>
                                        <group-messages :gmessages="gmessages" :user="{{Auth::user()}}" :group_id="group_id"></group-messages>
                                        <div class="form-chat">
                                            <button type="button" class="btn btn-info btn-sm pull-left" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-paperclip"></i></button>
                                            <groupchat-form v-on:groupmessagesent="sendGroupMessage" :group_id="group_id" :user="{{Auth::user()}}" ></groupchat-form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Add-->
                      <div id="addModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Create Group Thread</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p><b>NOTE:</b> Should have more than two members</p>
                                <?php
                                  $users = User::all();
                                ?>
                                <div style="overflow-y: scroll;height: 400px;">
                                    <group-add 
                                      v-on:groupadd="createGroup1"
                                      :curr_user="{{ Auth::user() }}"
                                      :users="{{ $users }}">        
                                    </group-add>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Modal Members -->
                      <div id="viewMembersModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Group Thread Members</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div> 
                            <div class="modal-body">
                                <p><b>NOTE:</b> The users here are the current members of the group thread</p>
                                <div style="overflow-y: scroll;height: 200px;">
                                    <groupchat-members 
                                      :curr_user="{{ Auth::user() }}"
                                      :members="members"
                                      :group="group">        
                                    </groupchat-members>
                                </div>
                                <hr>
                                <h4 class="modal-title">Add Thread Member</h4>
                                <p><b>NOTE:</b> Add other users to this group thread</p>
                                <div>
                                    <groupchat-addmembers 
                                      :curr_user="{{ Auth::user() }}"
                                      :group="group"
                                      :nonmembs="nonmembs"
                                      :group_id="group_id"
                                      >        
                                    </groupchat-addmembers>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end -->
                      <!-- modal of send file (single) -->
                        <div id="singleUploadModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Upload file</h4>
                                    </div>
                                    <div class="modal-body">
                                        <chat-upload
                                            v-on:singlefilesend="chatSendFile"
                                            :user="{{ Auth::user()->id }}"
                                            :to_id="to_id">
                                        </chat-upload>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end send of file modal -->
                      <!-- modal of send file (group) -->
                        <div id="uploadModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Upload file</h4>
                                    </div>
                                    <div class="modal-body">
                                        <group-upload
                                            v-on:filesend="sendFile"
                                            :group_id="group_id" 
                                            :user="{{Auth::user()->id}}">
                                        </group-upload>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end send of file modal -->
                        <!-- single chat files modal -->
                        <div id="chatFiles" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Thread Files</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <chatfile-search
                                            :to_id="to_id"
                                            :user="{{Auth::user()->id}}"
                                            ></chatfile-search>
                                        </div>
                                        <chat-files 
                                        :to_user="to_user"
                                        :sfiles="sfiles"
                                        ></chat-files>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end single chat files modal -->
                        <!-- group files modal -->
                        <div id="groupFiles" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Group Files</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <groupfile-search
                                            :group_id="group_id">
                                            </groupfile-search>
                                        </div>
                                        <group-files 
                                        :to_group="to_group"
                                        :files="files"
                                        ></group-files>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end group files modal -->
                    </div>
                  </div>
                </div>
                <div class="footer">
                    <div class="pull-right">
                        <strong>PROVERBS 16:3</strong>
                    </div>
                    <div>
                        <strong>Copyright</strong> DAVIES PAINT PHILIPPINES INCORPORATED 2017
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <!-- Mainly scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="/assets/js/jquery-3.1.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="/assets/js/plugins/dataTables/datatables.min.js"></script>
    <script src="/assets/js/jquery.filer.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/assets/js/inspinia.js"></script>
    <script>
        $(document).ready(function () {
            $('.dropdown-toggle').dropdown();
        });
    </script>
    <script type="text/javascript">
        // Open chat widget
        $('.userclick').on('click', function(){
            $('.single').removeClass(this);
            $('.small-chat-box-single').addClass('active').show();
        });

        // Open Group chat widget
        $('.groupclick').on('click', function(){
            $('.group').removeClass(this);
            $('.small-chat-box-group').addClass('active').show();
        });

        // Close Chat box
        $('.close-single').on('click', function(){
            $('.single').removeClass(this);
            $('.small-chat-box-single').hide();
        });

        //Close Group Chat box
        $('.close-group').on('click', function(){
            $('.group').removeClass(this);
            $('.small-chat-box').hide();
        });
        // Open close small chat
        $('.open-small-chat').on('click', function () {
            $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
            $('.small-chat-box').toggleClass('active');
        });

        // Initialize slimscroll for small chat
        $('.small-chat-box .content').slimScroll({
            height: '234px',
            railOpacity: 0.4
        });
        console.log('script loaded');
    </script>
    <script src="/assets/js/plugins/pace/pace.min.js"></script>    
    <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>  
    <!-- Multiselect -->
    <script src="/assets/bootstrap-multiselect-0.9.13/js/bootstrap-multiselect.js"></script>
     <!-- Data picker -->
    <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="/assets/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js"></script>
    <script src="/js/vue_chat.js"></script>
    <script src="/js/vuex.js"></script>   
    <script src="/js/push.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>    
    <script type="text/javascript">
        $('#user_id').multiselect({
            maxHeight: 200,
            enableCaseInsensitiveFiltering: true,
            enableFiltering: true,
            buttonWidth: '100%',
            buttonClass: 'form-control',
        });
        
        $(document).ready(function(){
            //Datatables
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,                                            
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            
           @section('page-script')
           @show
        });

    </script>
</body>

</html>
