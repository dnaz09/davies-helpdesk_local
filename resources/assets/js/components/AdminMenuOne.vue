<template>
    <div>
        <ul v-for="assetpending in assetpending">
            <li>
                <div class="dropdown-messages-box" @click="openPending(assetpending.req_no)">
                    <a href="#" class="pull-left">
                        <strong>{{assetpending.req_no}}</strong>
                    </a>
                    <div class="media-body">
                        <small class="pull-right">Requested at {{assetpending.created_at}}</small><br>
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
        props: ['assetpending'],
        methods: {
            openPending(id) {
                window.open('/asset_request/'+id+'/details', '_blank');
            }
        }
    };
</script>