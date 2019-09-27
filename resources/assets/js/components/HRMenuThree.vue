<template>
    <div>
        <ul v-for="undertime in undertimes">
            <li>
                <div class="dropdown-messages-box" @click="openPending(undertime.id)">
                    <a href="#" class="pull-left">
                        <strong>{{undertime.und_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{undertime.created_at}}</small><br>
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
        props: ['undertimes'],
        methods: {
            openPending(id) {
                window.open("/hrd_undertime/"+id+"/details");
            }
        }
    };
</script>