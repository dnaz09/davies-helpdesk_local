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
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"> --}}
    <link href="/assets/css/toastr.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/> --}}
    <link rel="stylesheet" href="/assets/css/fullcalendar.min.css"/>
    
    <link href="/assets/css/styleowa.css" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
        ]) !!};
    </script>
    <style>
        #loading {
            background: url('/assets/img/loading2.gif') no-repeat center center;
            position:fixed;
            width:100%;
            left:0;right:0;top:0;bottom:0;
            background-color: rgba(255,255,255, 0.6);
            z-index:9999;
        }
        body{
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?php $routeUri = Route::currentRouteName();?>
    <?php $user = Auth::user(); ?>
    <?php $imgURL = (!$user->image ? 'default.jpg' : $user->image); ?>   
    <?php 
        use App\User;
        use App\AccessControl;
        use App\Module;
        $acces_controls = AccessControl::select('module_id')->where('user_id',$user->id)->get();
    ?>
    <div id="loading"></div>
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
                                <li><a href="/change_profile_picture">Change Profile Picture</a></li>                                        
                                <li><a href="../../user/reset/password.php">Change Password</a></li>                                                
                                <li class="divider"></li>
                                <li>{!! Html::decode(link_to_route('logout', '<i class="fa fa-sign-out"></i> Log out',array(), ['class' => 'large button'])) !!}</li>   
                            </ul>
                        </div>                        
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <?php 
                        $acc = [];
                    ?>
                    @foreach($acces_controls as $ac)
                        <?php $acc[] = $ac->module_id ?>
                    @endforeach
                    <?php 
                        $manager_module = [4,5,52,53,54,56,59,65];
                        $manager_modules = array_intersect($manager_module, $acc);
                        // hr approver
                        $hr_approver = [49];
                        $hr_approvers = array_intersect($hr_approver, $acc);
                        // $superior_module = [6,7,8,9,10,11,47,51,55];
                        $superior_module = [55];
                        $superior_modules = array_intersect($superior_module, $acc);
                        $maintenance_module = [12,13,14,15,16,17,18,19,20,46,48,68,71];
                        $maintenance_modules = array_intersect($maintenance_module, $acc);
                        $sap_module = [21];
                        $sap_modules = array_intersect($sap_module, $acc);
                        //it
                        $it_module = [23,22,24];
                        $it_modules = array_intersect($it_module, $acc);
                        $it_imploded = implode(',',array_fill(0, count($it_modules), '?'));

                        $it_report_module = [25];
                        $it_report_modules = array_intersect($it_report_module, $acc);
                        $announce_module = [26,61];
                        $announce_modules = array_intersect($announce_module, $acc);
                        // hr
                        $hr_module = [27,28,29,30,31,32,33,34,35,50];
                        $hr_modules = array_intersect($hr_module, $acc);
                        // Obp
                        $obp_module = [27,28];
                        $obp_modules = array_intersect($obp_module, $acc);
                        // Requisition
                        $req_module = [29,30];
                        $req_modules = array_intersect($req_module, $acc);
                        // Undertime
                        $und_module = [31,32];
                        $und_modules = array_intersect($und_module, $acc);
                        // Work Auth
                        $work_auth_module = [33,34];
                        $work_auth_modules = array_intersect($work_auth_module, $acc);
                        // Hr Report
                        $hr_report_module = [36];
                        $hr_report_modules = array_intersect($hr_report_module, $acc);
                        // HR Exit Pass
                        $hr_ext_module = [35];
                        $hr_ext_modules = array_intersect($hr_ext_module, $acc);
                        // Hr Emp Req
                        $hr_emp_module = [49,50];
                        $hr_emp_modules = array_intersect($hr_emp_module, $acc);

                        // admin
                        $admin_module = [37,38,39,40,41,42,63,64,67,70];
                        $admin_modules = array_intersect($admin_module, $acc);
                        // borrower
                        $borrower_module = [37,42,39,40,41];
                        $borrower_modules = array_intersect($borrower_module, $acc);
                        $borrower_imploded = implode(',',array_fill(0, count($borrower_module), '?'));
                        // job order
                        $joborder_module = [38,66];
                        $joborder_modules = array_intersect($joborder_module, $acc);
                        // supply
                        $supply_module = [64,63,70];
                        $supply_modules = array_intersect($supply_module, $acc);
                        // room reservation
                        $room_module = [67,69];
                        $room_modules = array_intersect($room_module, $acc);
                        // gatepass
                        $gatepass = [73,74,75,76];
                        $gatepasses = array_intersect($gatepass, $acc);
                        // reports
                        $admin_report_module = [44];
                        $admin_report_modules = array_intersect($admin_report_module, $acc);

                        $exit_pass_module = [45];
                        $exit_pass_modules = array_intersect($exit_pass_module, $acc);
                        $work_auth_guard_module = [62];
                        $work_auth_guard_modules = array_intersect($work_auth_guard_module, $acc);

                        $guard_module = [72];
                        $guard_modules = array_intersect($guard_module, $acc);

                        $it_list_module = [24];
                        $it_list_modules = array_intersect($it_list_module, $acc);
                        $hrd_module = [28,30,32,34,35];
                        $hrd_modules = array_intersect($hrd_module, $acc);
                        $ad_module = [39,40,41,42];
                        $ad_modules = array_intersect($ad_module, $acc);

                        $approver_module = [60];
                        $approver_modules = array_intersect($approver_module, $acc);
                    ?>
                    <!-- Dashboard -->
                    <li class="<?php echo ($routeUri=='dashboard') ? 'active' : '' ?>">{!! Html::decode(link_to_route('dashboard.index', '
                        <i class="fa fa-dashboard fa-2x"></i>
                        <span class="nav-label">Home</span>', array(), ['class' => 'large button'])) !!}
                    </li>
                    <!-- My account -->
                    @if(!in_array($user->id,[246,247]))
                    <li>
                        <a href="#"><i class="fa fa-gears fa-2x"></i> <span class="nav-label">My Account</span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">

                            <!-- superior -->
                            @if(count($superior_modules)>0)
                            <?php $superioraccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $superior_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-building fa-1x"></i> Superior <span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($superioraccess as $sm)
                                    <li class="{{ ($routeUri == $sm->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($sm->module->routeUri)}}">
                                            <i class="{{$sm->module->icon}}"></i> {{$sm->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <!-- mam tiff SAP approval-->
                            @if(count($sap_modules)>0)
                            <?php $sapaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $sap_modules)->get(); ?>
                            @foreach($sapaccess as $sap)
                            <li class="{{ ($routeUri == $sap->module->routeUri) ? 'active' : ' '}}">
                                <a href="{{route($sap->module->routeUri)}}">
                                    <i class="{{$sap->module->icon}}"></i> {{$sap->module->module}}
                                </a>
                            </li>
                            @endforeach
                            @endif
                            <!-- My request -->
                            <li class="<?php echo ($routeUri=='my_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('my_request_list.index', '
                                <i class="fa fa-inbox fa-1x"></i> My Request', array(), ['class' => 'large button'])) !!}
                            </li>
                            <li>
                                <a href="../../user/reset/password.php"> <i class="fa fa-wrench fa-1x"></i> Change Password</a>
                            </li>
                            <!-- <li>
                                <a href="../../user/reset/password.php"> <i class="fa fa-wrench fa-1x"></i> Change Username</a>
                            </li> -->
                        </ul>
                    </li>
                    @endif
                    <!-- approver of employee requisition -->
                    @if(count($approver_modules)>0)
                    <?php $ap = AccessControl::where('user_id',$user->id)->whereIn('module_id',$approver_modules)->first(); ?>
                    <li class="<?php echo ($routeUri=='$ap->module->routeUri') ? 'active' : '' ?>">
                        <a href="{{route($ap->module->routeUri)}}">
                            <i class="{{$ap->module->icon}}"></i>
                            <span class="nav-label">{{$ap->module->module}}</span>
                        </a>
                    </li>
                    @endif
                    <!-- maintenance -->
                    @if(count($maintenance_modules)>0)
                    <?php $filemaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id',$maintenance_modules)->get(); ?>
                    <li>
                        <a href="#"><i class="fa fa-gears fa-2x"></i> <span class="nav-label">Maintenance </span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            @foreach($filemaccess as $fm)
                            <li class="{{ ($routeUri == $fm->module->routeUri) ? 'active' : ' '}}">
                                <a href="{{route($fm->module->routeUri)}}">
                                    <i class="{{$fm->module->icon}}"></i> {{$fm->module->module}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    <!-- dept manager -->
                    @if(count($manager_modules)>0)
                    <?php $manageraccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $manager_modules)->get(); ?>
                    <li>
                        <a href="#"><i class="fa fa-building fa-2x"></i> <span class="nav-label">My Department</span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            @foreach($manageraccess as $mm)
                            <li class="{{ ($routeUri == $mm->module->routeUri) ? 'active' : ' '}}">
                                <a href="{{route($mm->module->routeUri)}}">
                                    <i class="{{$mm->module->icon}}"></i> {{$mm->module->module}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    <!-- it helpdesk -->
                    @if(count($it_modules)>0)
                    <?php $itaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $it_modules)->orderByRaw("field(module_id,{$it_imploded})", $it_modules)->get(); 
                    ?>
                    <li>
                        <a href="#"><i class="fa fa-laptop fa-2x"></i> <span class="nav-label">IT Helpdesk</span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            @foreach($itaccess as $im)
                            <li class="{{ ($routeUri == $im->module->routeUri) ? 'active' : ' '}}">
                                <a href="{{route($im->module->routeUri)}}">
                                    <i class="{{$im->module->icon}}"></i> {{$im->module->module}}
                                </a>
                            </li>
                            @endforeach

                            <!-- it reports -->
                            @if(count($it_report_modules)>0)
                            <?php $itrepsaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $it_report_modules)->get(); ?>
                                @foreach($itrepsaccess as $ipm)
                                <li class="{{ ($routeUri == $ipm->module->routeUri) ? 'active' : ' '}}">
                                    <a href="{{route($ipm->module->routeUri)}}">
                                        <i class="{{$ipm->module->icon}}"></i> {{$ipm->module->module}}
                                    </a>
                                </li>
                                @endforeach
                            @endif

                        </ul>
                    </li>
                    @endif
                    <!-- announcement -->
                    @if(count($announce_modules)>0)
                    <?php $announceaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $announce_modules)->get(); ?>
                    <li>
                        <a href="#"><i class="fa fa-bullhorn fa-2x"></i> <span class="nav-label">Announcement </span><span class="fa arrow fa-2x"></span></a>
                        <ul class="nav nav-second-level collapse">
                            @foreach($announceaccess as $anm)
                            <li class="{{ ($routeUri == $anm->module->routeUri) ? 'active' : ' '}}">
                                <a href="{{route($anm->module->routeUri)}}">
                                    <i class="{{$anm->module->icon}}"></i> {{$anm->module->module}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    <!-- hr -->
                    @if(count($hr_modules)>0)
                    <?php $hraccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $hr_modules)->get(); ?>
                    <li>
                        <a href="#"><i class="fa fa-users fa-2x"></i> <span class="nav-label">HR Department </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">
                            @if(count($obp_modules)>0)
                            <?php $obpaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$obp_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-file fa-1x"></i> OBP<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($obpaccesses as $ob)
                                    <li class="{{ ($routeUri == $ob->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($ob->module->routeUri)}}"> {{$ob->module->module}}
                                        </a>
                                    </li>
                                    @endforeach


                                </ul>
                            </li>
                            @endif
                            @if(count($req_modules)>0)
                            <?php $reqaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$req_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-braille fa-1x"></i> Requisition<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($reqaccesses as $req)
                                    <li class="{{ ($routeUri == $req->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($req->module->routeUri)}}"> {{$req->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            @if(count($und_modules)>0)
                            <?php $undaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$und_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-clock-o fa-1x"></i> Leave<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($undaccesses as $und)
                                    <li class="{{ ($routeUri == $und->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($und->module->routeUri)}}"> {{$und->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            @if(count($work_auth_modules)>0)
                            <?php $wasaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$work_auth_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-users fa-1x"></i> Work Authorization<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($wasaccesses as $was)
                                    <li class="{{ ($routeUri == $was->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($was->module->routeUri)}}"> {{$was->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                    <!-- My tagged request -->
                                    <li class="<?php echo ($routeUri=='tagged_request_list') ? 'active' : '' ?>">{!! Html::decode(link_to_route('tagged_request_list.list', ' My Tagged Request', array(), ['class' => 'large button'])) !!}
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if(count($hr_ext_modules)>0)
                            <?php $extaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$hr_ext_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-lock fa-1x"></i> Exit Pass<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($extaccesses as $ext)
                                    <li class="{{ ($routeUri == $ext->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($ext->module->routeUri)}}"> {{$ext->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            @if(count($hr_emp_modules)>0)
                            <?php $empaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$hr_emp_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-user-o fa-1x"></i> Employee Requisition<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($empaccesses as $emp)
                                    <li class="{{ ($routeUri == $emp->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($emp->module->routeUri)}}"> {{$emp->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <!-- Downloadable -->
                            <li class="<?php echo ($routeUri=='files') ? 'active' : '' ?>">{!! Html::decode(link_to_route('files.index', '
                                <i class="fa fa-thumbs-up fa-1x"></i> Downloadable Forms', array(), ['class' => 'large button'])) !!}
                            </li>
                            <!-- hrd reports -->
                            @if(count($hr_report_modules)>0)
                            <?php $hrrepaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $hr_report_modules)->get(); ?>
                                @foreach($hrrepaccess as $hrm)
                                <li class="{{ ($routeUri == $hrm->module->routeUri) ? 'active' : ' '}}">
                                    <a href="{{route($hrm->module->routeUri)}}">
                                        <i class="{{$hrm->module->icon}}"></i> {{$hrm->module->module}}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @endif
                    <!-- admin department -->
                    @if(count($admin_modules)>0)
                    <li>
                        <a href="#"><i class="fa fa-user fa-2x"></i> <span class="nav-label">Admin Department </span><span class="fa arrow fa-2x"></span></a>                        
                        <ul class="nav nav-second-level collapse">
                            <!-- borrower module -->
                            @if(count($borrower_modules)>0)
                            <?php $borroweraccess = AccessControl::where('user_id',$user->id)->whereIn('module_id',$borrower_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-archive fa-1x"></i> Borrowed Items <span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($borroweraccess as $baa)
                                    <li class="{{ ($routeUri == $baa->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($baa->module->routeUri)}}"> {{$baa->module->module}}
                                        </a>
                                    </li>
                                    @endforeach

                                    <!-- my borrowed items -->
                                    <li class="<?php echo ($routeUri=='userasset_trackings') ? 'active' : '' ?>">{!! Html::decode(link_to_route('userasset_trackings.list', '
                                        My Borrowed Items', array(), ['class' => 'large button'])) !!}
                                    </li>
                                    <!-- my asset history -->
                                    <li class="<?php echo ($routeUri=='borrow_history') ? 'active' : '' ?>">{!! Html::decode(link_to_route('borrow_history.index', '
                                        My Borrow History', array(), ['class' => 'large button'])) !!}
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if(count($room_modules)>0)
                            <?php $roomaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$room_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-archive fa-1x"></i> Room Reservation </span><span class="fa arrow fa-1x"></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($roomaccesses as $rm)
                                    <li class="{{ ($routeUri == $rm->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($rm->module->routeUri)}}"> {{$rm->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <!-- job order -->
                            @if(count($joborder_modules)>0)
                            <?php $joaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$joborder_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-wrench fa-1x"></i> Job Order <span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($joaccesses as $joa)
                                    <li class="{{ ($routeUri == $joa->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($joa->module->routeUri)}}"> {{$joa->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <!-- supply request -->
                            @if(count($joborder_modules)>0)
                            <?php $supplyaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id',$supply_modules)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-inbox fa-1x"></i> Material Request <span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($supplyaccess as $sup)
                                    <li class="{{ ($routeUri == $sup->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($sup->module->routeUri)}}"> {{$sup->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <!-- gatepass request -->
                            @if(count($gatepasses)>0)
                            <?php $gatepassaccesses = AccessControl::where('user_id',$user->id)->whereIn('module_id',$gatepasses)->get(); ?>
                            <li>
                                <a href="#"><i class="fa fa-inbox fa-1x"></i> Gatepass Request<span class="fa arrow fa-1x"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    @foreach($gatepassaccesses as $gp)
                                    <li class="{{ ($routeUri == $gp->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($gp->module->routeUri)}}"> {{$gp->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif

                            <!-- admin reports -->
                            @if(count($admin_report_modules)>0)
                            <?php $adminrepaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $admin_report_modules)->get(); ?>
                                    @foreach($adminrepaccess as $arm)
                                    <li class="{{ ($routeUri == $arm->module->routeUri) ? 'active' : ' '}}">
                                        <a href="{{route($arm->module->routeUri)}}">
                                            <i class="{{$arm->module->icon}}"></i> {{$arm->module->module}}
                                        </a>
                                    </li>
                                    @endforeach
                            @endif
                        </ul>
                    </li>
                    @endif


                    <!-- Exit Pass Checker -->
                    @if(count($exit_pass_modules)>0)
                    <?php $epassaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $exit_pass_modules)->get(); ?>
                    @foreach($epassaccess as $epass)
                    <li class="{{ ($routeUri == $epass->module->routeUri) ? 'active' : ' '}}">
                        <a href="{{route($epass->module->routeUri)}}">
                            <i class="{{$epass->module->icon}}"></i>
                            <span class="nav-label">{{$epass->module->module}}</span>
                        </a>
                    </li>
                    @endforeach
                    @endif
                    <!-- Work Auth Guard Checker -->
                    @if(count($work_auth_guard_modules)>0)
                    <?php $wguardaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $work_auth_guard_modules)->get(); ?>
                    @foreach($wguardaccess as $wguardpass)
                    <li class="{{ ($routeUri == $wguardpass->module->routeUri) ? 'active' : ' '}}">
                        <a href="{{route($wguardpass->module->routeUri)}}">
                            <i class="{{$wguardpass->module->icon}}"></i>
                            <span class="nav-label">{{$wguardpass->module->module}}</span>
                        </a>
                    </li>
                    @endforeach
                    @endif
                    <!-- Guard Reports -->
                    @if(count($guard_modules)>0)
                    <?php $guardoaccess = AccessControl::where('user_id',$user->id)->whereIn('module_id', $guard_modules)->get(); ?>
                    @foreach($guardoaccess as $ga)
                    <li class="{{ ($routeUri == $ga->module->routeUri) ? 'active' : ' '}}">
                        <a href="{{route($ga->module->routeUri)}}">
                            <i class="{{$ga->module->icon}}"></i>
                            <span class="nav-label"> {{$ga->module->module}}</span>
                        </a>
                    </li>
                    @endforeach
                    @endif
                    @if(!in_array($user->id,[246,247]))

                    <!-- Directory -->
                    <li class="<?php echo ($routeUri=='directory') ? 'active' : '' ?>">{!! Html::decode(link_to_route('directory.index', '
                        <i class="fa fa-search fa-2x"></i>
                        <span class="nav-label">Directory</span>', array(), ['class' => 'large button'])) !!}
                    </li>



                    @endif
                    @if(in_array($user->id,[246,247,1]))
                    <li class="<?php echo ($routeUri=='guard_reports') ? 'active' : '' ?>">{!! Html::decode(link_to_route('guardrep.index', '
                        <i class="fa fa-inbox fa-2x"></i>
                        <span class="nav-label">Security Reports</span>', array(), ['class' => 'large button'])) !!}
                    </li>
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
                        @if(count($ad_modules)>0)
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                ITEM REQUEST  <adminnotif-one :assetp="assetp"></adminnotif-one>
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
                                PENDING ITEMS  <adminnotif-three :totalassetrp="totalassetrp"></adminnotif-three>
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
                        @if(count($hr_approvers)>0)
                        <!-- EMP REQUISITION -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    Employee Requisition <hrapprovernotif :emp_req_p="emp_req_p"></hrapprovernotif>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <hrapprovermenu :emp_reqs="emp_reqs"></hrapprovermenu>
                                    <li>
                                        <a href="{{route('hrd_emp_req.list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if(count($hrd_modules)>0)
                        <!-- OBP -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    OB <hrnotif-one :obp_p="obp_p"></hrnotif-one>
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
                                    Leave  <hrnotif-three :undertime_p="undertime_p"></hrnotif-three>
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
                        @if(count($sap_modules)>0)
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
                        @if(count($it_list_modules)>0)
                        <!-- IT -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    IT Request  <itnotif :itscount="itscount"></itnotif>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <itmenu :its="its"></itmenu>
                                    <li>
                                        <a href="{{url('it_request_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <!-- My Request -->
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    My Request  <mynotif 
                                                    :mysum="mysum"
                                                ></mynotif>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <mymenu 
                                        :myworks="myworks"
                                        :myunds="myunds"
                                        :myitems="myitems"
                                        :myobps="myobps"
                                        :myreqs="myreqs"
                                        :myits="myits"
                                    ></mymenu>
                                    <li>
                                        <a href="{{url('my_request_list')}}">
                                            <center>View All</center>
                                        </a>
                                    </li>
                                </ul>
                            </li>
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
      function hideLoader() {
          $('#loading').fadeOut("slow");
          // $('#loading').hide();
          $("body").css({ 'overflow' : 'auto'});
      }

      $(window).on('beforeunload', function(){
          
          $("body").css({ 'overflow' : 'hidden'});

          $(window).scrollTop(0);
      });
              $(window).ready(hideLoader)
      

      // Strongly recommended: Hide loader after 20 seconds, even if the page hasn't finished loading
      setTimeout(hideLoader, 20 * 1000);
  </script>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
  @section('calendar')

  @show
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
          $('#dataTables-admin-jo').DataTable({
              pageLength: 25,
              responsive: true,                                          
              order: [0, 'desc'],
          });

          $('#dataTables-superior').DataTable({
              pageLength: 25,
              responsive: true,                                          
              order: [0, 'desc'],
          });

          $('.dataTables-leave').DataTable({
              pageLength: 25,
              responsive: true,                                          
              order: [0, 'desc'],
          });

          $('.dataTables-obp').DataTable({
              pageLength: 25,
              responsive: true,                                          
              order: [0, 'desc'],
          });

          $('.dataTables-deptmng-obp').DataTable({
              pageLength: 25,
              responsive: true,                                          
              order: [0, 'desc'],
          });

          $('.dataTables-req').DataTable({
              pageLength: 25,
              responsive: true,                                          
              order: [0, 'desc'],
          });

          // $('.dataTables-was').DataTable({
          //     pageLength: 25,
          //     responsive: true,                                          
          //     order: [0, 'desc'],
          //     // searching: false,
          //     // paging: false
          // });

          $('.dataTables-example').DataTable({
              pageLength: 25,
              responsive: true,
              order: [0, 'desc']
          });
          $('.dataTables-workauth').DataTable({
              pageLength: 25,
              responsive: true,
              order: [1, 'desc']
          });
          $('.dataTables-it-all').DataTable({
              pageLength: 25,
              responsive: true,
              order: [0, 'desc']
          });

          $('.dataTables-it_all-two').DataTable({
              pageLength: 25,
              responsive: true,
              order: [0, 'desc']
          });

          $('.room-datatable-admin').DataTable({
              pageLength: 25,
              responsive: true,
              order: [0, 'desc']
          });

          $('.dataTables-room').DataTable({
              pageLength: 25,
              responsive: true,
              order: [0, 'desc'],
          });

          $('.dataTables-announcement').DataTable({
              pageLength: 10,
              responsive: true,  
              ordering: false,                                        
          });

          $('.dataTables-users').dataTable( {
              order: [4, 'asc'],
              pageLength: 100,
              responsive: true, 
          });

          $('.i-checks').iCheck({
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green',
          });
          
          function swal_ajax(data){

              /* data.process types:
                 0 = alert data
                 1 = alert url
                 2 = production
              */
              switch(data.process_type){
                  case 0:
                      alert(data.ajax_data);
                  break;

                  case 1:
                      alert(data.ajax_url);
                  break;

                  case 2: 
                      swal({
                          title: data.swal_title,
                          text: data.swal_text,
                          icon: data.swal_icon,
                          dangerMode: true,
                          showCancelButton: true,
                          confirmButtonText: data.swal_button
                      },function(){
                          $.ajax({
                                url: data.ajax_url,
                                type: data.ajax_type,
                                data: data.ajax_data,
                                success: function(response){ 
                                    console.log(response);
                                  if(response == 'S'){
                                      swal(
                                        'Success!',
                                        data.swal_success,
                                        'success'
                                      )

                                      setTimeout(function() {
                                          location.reload();
                                      }, 1000);
                                  }
                                }
                          });
                      });
                  break;

                  default:
              }
          }

         @section('page-script')
         @show
      });
      @section('page-javascript')
      @show

  </script>
</body>

</html>