<template>
    <div>
        <ul v-for="it in its">
            <li>
                <div class="dropdown-messages-box" @click="openRelease(it.reqit_no)">
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
    </div>
</template>
<script>
    export default {
        props: ['its'],
        methods: {
            openRelease(id) {
                window.open('/it_request_list/'+id+'/details', '_blank');
            }
        }
    };
</script>