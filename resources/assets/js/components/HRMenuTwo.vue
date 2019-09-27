<template>
    <div>
        <ul v-for="workauth in workauths">
            <li>
                <div class="dropdown-messages-box" @click="openPending(workauth.work_auth_id)">
                    <a href="#" class="pull-left">
                        <strong>{{workauth.work_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{workauth.created_at}}</small><br>
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
        props: ['workauths'],
        methods: {
            openPending(id) {
                window.open("/hrd_work_authorization/"+id+"/details");
            }
        }
    };
</script>