<template>
    <div>
        <ul v-for="assetrp in assetrp">
            <li>
                <div class="dropdown-messages-box" @click="openRelease(assetrp.asset_request_no)">
                    <a href="#" class="pull-left">
                        <strong>{{assetrp.asset_request_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{assetrp.created_at}}</small><br>
                        is still pending to be released, click here for more details <br>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: ['assetrp'],
        methods: {
            openRelease(id) {
                window.open('/asset_request/'+id+'/release', '_blank');
            }
        }
    };
</script>