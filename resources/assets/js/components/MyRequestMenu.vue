<template>
    <div>
        <ul v-for="it in myits">
            <li>
                <div class="dropdown-messages-box" @click="openReleaseIT(it.reqit_no)">
                    <a href="#" class="pull-left">
                        <strong>{{it.reqit_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{it.created_at}}</small><br>
                        is still pending, click here for more details <br>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        </ul>
        <ul v-for="work in myworks">
            <li>
                <div class="dropdown-messages-box" @click="openReleaseWork(work.work_auth_id)">
                    <a href="#" class="pull-left">
                        <strong>WA{{work.work_auth_id}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{work.created_at}}</small><br>
                        is still pending, click here for more details <br>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        </ul>
        <ul v-for="und in myunds">
            <li>
                <div class="dropdown-messages-box" @click="openReleaseUnd(und.id)">
                    <a href="#" class="pull-left">
                        <strong>U{{und.id}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{und.created_at}}</small><br>
                        is still pending, click here for more details <br>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        </ul>
        <ul v-for="item in myitems">
            <li>
                <div class="dropdown-messages-box" @click="openReleaseItem(item.req_no)">
                    <a href="#" class="pull-left">
                        <strong>{{item.req_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{item.created_at}}</small><br>
                        is still pending, click here for more details <br>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        </ul>
        <ul v-for="req in myreqs">
            <li>
                <div class="dropdown-messages-box" @click="openReleaseReq(req.rno)">
                    <a href="#" class="pull-left">
                        <strong>{{req.rno}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{req.created_at}}</small><br>
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
        props: [
            'myworks',
            'myunds',
            'myitems',
            'myobps',
            'myreqs',
            'myits'
        ],
        methods: {
            openReleaseIT(id) {
                window.open("/my_request_list/it/"+id+"/details");
            },
            openReleaseWork(id) {
                window.open("/work_authorization/"+id+"/details");
            },
            openReleaseUnd(id) {
                window.open("/undertime/"+id+"/details");
            },
            openReleaseItem(id) {
                window.open("/my_request_list/asset/"+id+"/details");
            },
            openReleaseReq(id) {
                window.open("/requisition/"+id+"/details");
            }
        }
    };
</script>