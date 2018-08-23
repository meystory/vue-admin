<template>
<div>
    <pane></pane>
    <div class="page-container"> 
        <sidebar></sidebar>
        <div class="main-content">
            <router-view></router-view>
        </div>
    </div>
</div>
</template>
<script>
    // import { mapActions,mapGetters} from 'vuex';
    import Pane from './Pane.vue';
    import Sidebar from './Sidebar.vue';

    export default {
        components: {
            Pane,
            Sidebar
        },
        mounted () {

        },
        methods:{

        }


    }

</script>