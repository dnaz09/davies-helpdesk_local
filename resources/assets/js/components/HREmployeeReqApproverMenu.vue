<template>
    <div>
        <ul v-for="emp_req in emp_reqs">
            <li>
                <div class="dropdown-messages-box" @click="openPending(emp_req.ereq_no)">
                    <a href="#" class="pull-left">
                        <strong>{{emp_req.ereq_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{emp_req.created_at}}</small><br>
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
        props: ['emp_reqs'],
        methods: {
            openPending(id) {
                window.open("/hrd_emp_req/"+id+"/details");
            }
        }
    };
</script>