<template>
    <div>
        <ul v-for="pendingobp in pendingobps">
            <li>
                <div class="dropdown-messages-box" @click="openPending(pendingobp.id)">
                    <a href="#" class="pull-left">
                        <strong>{{pendingobp.obpno}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{pendingobp.created_at}}</small><br>
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
        props: ['pendingobps'],
        methods: {
            openPending(id) {
                window.open("/hrd_obp/"+id+"/details");
            }
        }
    };
</script>