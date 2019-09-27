<template>
	<div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <span class="label label-primary pull-right">Total</span>
                    <h5 style="color:white">User Access Request</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins font-bold">{{mtog}}</h1>  
                    <small class="font-bold text-danger">Ongoing</small> <br /><br />
                </div>
            </div>
        </div>
	</div>
</template>
<script>
	export default {
		props: ['mtog'],
	};
</script>