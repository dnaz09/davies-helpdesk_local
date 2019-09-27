<template>
	<div>
		<div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-info pull-right">Total</span>
                    <h5 style="color:white">Service Request</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{totals_pending1}}</h1>
                    <div class="stat-percent font-bold text-danger">{{totals_pending}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-danger">Ongoing</small> <br /><br />   
                    <h1 class="no-margins font-bold ">{{totals_returned1}}</h1>
                    <div class="stat-percent font-bold text-warning">{{totals_returned}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-primary">Returned</small> <br /><br />   
                    <h1 class="no-margins font-bold ">{{totals_solved1}}</h1>
                    <div class="stat-percent font-bold text-success">{{totals_solved}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-success">Solved</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-primary pull-right">Total</span>
                    <h5 style="color:white">User Access Request</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{totalu_pending1}}</h1>
                    <div class="stat-percent font-bold ">{{totalu_pending}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-danger">Ongoing</small> <br /><br />   
                    <h1 class="no-margins font-bold ">{{totalu_returned1}}</h1>
                    <div class="stat-percent font-bold text-warning">{{totalu_returned}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-primary">Returned</small> <br /><br />   
                    <h1 class="no-margins font-bold ">{{totalu_solved1}}</h1>
                    <div class="stat-percent font-bold text-success">{{totalu_solved}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-success">Solved</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-success pull-right">Total Request</span>
                    <h5 style="color:white">IT REQUEST</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold ">{{total_it_pending1}}</h1>
                    <div class="stat-percent font-bold text-danger">{{total_it_pending}}%  <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-danger">Ongoing</small> <br /><br />   
                    <h1 class="no-margins font-bold">{{total_it_returned1}}</h1>
                    <div class="stat-percent font-bold text-warning">{{total_it_returned}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-primary">Returned</small> <br /><br />   
                    <h1 class="no-margins font-bold">{{total_it_solved1}}</h1>
                    <div class="stat-percent font-bold text-success">{{total_it_solved}}% <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-success">Solved</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-danger pull-right">Individual</span>
                    <h5 style="color:white">Solved</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{solved_service1}}</h1>
                    <div class="stat-percent font-bold ttext-success">{{solved_service}}% <i class="fa fa-bolt"></i></div>
                    <small>In Service Request</small> <br /><br />
                    <h1 class="no-margins font-bold">{{solved_access1}}</h1>
                    <div class="stat-percent font-bold text-success">{{solved_access}}% <i class="fa fa-bolt"></i></div>
                    <small>In User Access Request</small>

                </div>

            </div>
        </div>
	</div>
</template>
<script>
	export default {
		props: [
			'totals_pending',
			'totals_returned',
			'totals_solved',
			'totalu_pending',
			'totalu_returned',
			'totalu_solved',
			'total_it_pending',
			'total_it_returned',
			'total_it_solved',
			'solved_service',
			'solved_access',
			'totals_pending1',
			'totals_returned1',
			'totals_solved1',
			'totalu_pending1',
			'totalu_returned1',
			'totalu_solved1',
			'total_it_pending1',
			'total_it_returned1',
			'total_it_solved1',
			'solved_service1',
			'solved_access1',
		],
	};
</script>