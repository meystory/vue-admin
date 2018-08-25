<template>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">角色列表</h3>
    </div>
    <div class="panel-body">
        <div class="form-inline dt-bootstrap">
            <div class="row">
                <div class="col-xs-8"></div>
                <div class="col-xs-2">

                        <button type="button" class="btn btn-turquoise btn-sm" v-if="can('/role/edit')" @click="editRole()"><i
                                        class="fa fa-users"></i>&ensp;新建</button>
                </div>
            </div>

            <vTable
                 ref="table"
                :ajaxUrl="ajaxUrl"
                :params="params"
                :lists="lists"
                :perPage="params.limit"
                :ths="ths"
                :del="del"
            >
                <template slot="role_name" slot-scope="items">
                        {{ items.value }}
                </template>
                <template slot="creator" slot-scope="items">
                        {{ items.value }}
                </template>
                <template slot="use_status" slot-scope="items">
                    <span :class="items.value == 1 ? 'text-green':'' ">{{ items.value == 1 ? '使用中' : '暂未使用'}}</span>     
                </template>
                <template slot="created_at" slot-scope="items">
                        {{ items.value }}
                </template>
                <template slot="actions" slot-scope="items">

                        <a href="javascript:void(0);"  v-if="can('/role/edit')" @click.prevent="editRole(items.item.role_id)"  class="btn btn-secondary btn-sm btn-icon icon-left">
                            修改
                        </a>
                        
                        <a href="javascript:void(0);"  v-if="can('/role/del')" @click.prevent="$refs.table.onDel({role_id:items.item.role_id})" class="btn btn-danger btn-sm btn-icon icon-left">
                            删除
                        </a>
                        
                        <a href="javascript:void(0);" @click.prevent="getDetail(items.item.role_id)" class="btn btn-info btn-sm btn-icon icon-left">
                            详情
                        </a>
                </template> 
            </vTable>

            <!-- 详情展示模态 -->
            <!-- <modal ref="detail-modal"></modal> -->
        </div>
     
    </div>
</div>



</template>


<script>
    import vTable from 'components/common/Table.vue';
    import modal from './Modal.vue';
    export default {
        components: { 
            vTable , 
            modal
        },
        data(){
            return {
                lists: [],
                ths: {
                    role_name: {label: '角色名'},
                    creator: {label: '创建人'},
                    use_status:{label:'使用状态'},
                    created_at: {label: '创建时间', sortable: true},
                    actions: {label: '操作'}
                },
                ajaxUrl: "/role/list",
                params: {
                    limit: 20,
                    keywords: "",
                },

                del: {  
                    url:'/role/del',
                    title:'确定要删除该角色吗?'
                },
            }
        },
        methods: {
            editRole(role_id) {
                let url = role_id ? `/role/edit/${role_id}`  : `/role/edit`;
                this.$router.push({ path: url });
            },
            getDetail(role_id) {
                this.$refs['detail-modal'].loadTree(role_id);
            },
            delRole() {
                this.$axios({
                    url : '/role/del',
                    data: { role_id: role_id},
                    success:function(data){

                    },
                });
            }
        }
    }
</script>