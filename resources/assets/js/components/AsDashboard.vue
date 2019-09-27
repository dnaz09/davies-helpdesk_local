<template>
	<div>
		<div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-success pull-right">Total Pending</span>
                    <h5 style="color:white">Asset Request</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold ">{{assetp}}</h1>
                    <div class="stat-percent font-bold text-danger">{{totalasset}}%  <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-danger">Ongoing</small> <br /><br />                       
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-success pull-right">Total Pending</span>
                    <h5 style="color:white">Job Order Request</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold ">{{jop}}</h1>
                    <div class="stat-percent font-bold text-danger">{{totaljo}}%  <i class="fa fa-bolt"></i></div>   
                    <small class="font-bold text-danger">Ongoing</small> <br /><br />                       
                </div>
            </div>
        </div>
	</div>
</template>
<script>
	export default {
		props: ['assetp','totalasset','jop','totaljo']
	};
</script>