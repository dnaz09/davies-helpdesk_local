<template>
    <div>
        <ul v-for="exitpass in exitpass">
            <li>
                <div class="dropdown-messages-box" @click="openPending(exitpass.id)">
                    <a href="#" class="pull-left">
                        <strong>{{exitpass.exit_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{exitpass.created_at}}</small><br>
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
        props: ['exitpass'],
        methods: {
            openPending(id) {
                window.open("/hrd_exit_list/"+id+"/details");
            }
        }
    };
</script>