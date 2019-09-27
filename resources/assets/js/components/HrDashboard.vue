<template>
	<div>
		<div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-warning pull-right">Pending</span>
                    <h5 style="color:white">Work Authorization</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{workauth_p}}</h1>
                    <div class="stat-percent font-bold ttext-success">{{totalworkauth}}% <i class="fa fa-bolt"></i></div>
                    <small>Total Pending</small> <br /><br />                    
                </div>

            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-primary pull-right">Pending</span>
                    <h5 style="color:white">OBP</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{obp_p}}</h1>
                    <div class="stat-percent font-bold ttext-success">{{totalobp}}% <i class="fa fa-bolt"></i></div>
                    <small>Total Pending</small> <br /><br />                   
                </div>

            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-success pull-right">Pending</span>
                    <h5 style="color:white">Undertime</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{undertime_p}}</h1>
	                    <div class="stat-percent font-bold ttext-success">{{totalundertime}}% <i class="fa fa-bolt"></i></div>
                    <small>Total Pending</small> <br /><br />
                    
                </div>

            </div>
        </div>
        
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-info pull-right">Pending</span>
                    <h5 style="color:white">Requisition</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{requisition_p}}</h1>
                    <div class="stat-percent font-bold ttext-success">{{totalrequisition}}% <i class="fa fa-bolt"></i></div>
                    <small>Total Pending</small> <br /><br />
                    
                </div>

            </div>
        </div>
	</div>
</template>
<script>
	export default {
		props: [
			'totalrequisition',
			'totalundertime',
			'totalobp',
			'totalworkauth',
			'workauth_p',
			'obp_p',
			'undertime_p',
			'requisition_p'
			],
	};
</script>