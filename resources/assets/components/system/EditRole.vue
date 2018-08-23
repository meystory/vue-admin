<template>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">编辑角色权限</h3>
        <div class="col-xs-2 pull-right">
                <button type="button" class="btn btn-turquoise btn-sm" v-if="can('/role/edit')" @click="saveRoleNode()"><i
                                class="fa fa-users"></i>&ensp;保存</button>
        </div>
    </div>
    <div class="panel-body" style="min-height:500px;">
        <div class="col-md-12">
            <ul v-for="nodeItem in nodeTree" >
                <child-li :model="nodeItem"></child-li>
            </ul>
        </div>
    </div>
</div>
</template>

<script>
    import ChildLi from './ChildLi.vue';
    export default {
        components: {
            'child-li':ChildLi
        },
        data(){
            return {
                nodeTree:[],
            }
        },
        created() {
            let role_id = this.$route.params.role_id; 
            this.$Progress.start();
            this.$axios({
                type: 'post',
                url : '/role/detail',
                data: { role_id: role_id},
                success:function(data){
                    this.$Progress.finish();
                    this.nodeTree = data.node_tree;
                    this.$store.commit('checkNodes', data.role_node_ids);
                },
                
            });
        },
        methods: {
            saveRoleNode() {
                
            }
        }
    }
</script>