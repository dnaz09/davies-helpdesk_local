<template>
    <div>
        <ul v-for="reqs in reqs">
            <li>
                <div class="dropdown-messages-box" @click="openPending(reqs.rno)">
                    <a href="#" class="pull-left">
                        <strong>{{reqs.rno}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{reqs.created_at}}</small><br>
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
        props: ['reqs'],
        methods: {
            openPending(id) {
                window.open("/hrd_requisition/"+id+"/details");
            }
        }
    };
</script>