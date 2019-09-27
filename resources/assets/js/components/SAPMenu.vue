<template>
    <div>
        <ul v-for="sap in saps">
            <li>
                <div class="dropdown-messages-box" @click="openPending(sap.reqit_no)">
                    <a href="#" class="pull-left">
                        <strong>{{sap.reqit_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{sap.created_at}}</small><br>
                        is still pending, click here for more details <br>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: ['saps'],
        methods: {
            openPending(id) {
                window.open("/it_manager/"+id+"/mng_details");
            }
        }
    };
</script>