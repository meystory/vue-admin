<template>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">员工列表</h3>
    </div>
    <div class="panel-body">
        <div class="form-inline dt-bootstrap">
            <div class="row">
                <div class="col-xs-2">
                    <div class="from-group">
                        <label>每页 
                            <select v-model="limit" name="limit" class="form-control input-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                            </select> 条 
                        </label>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div  class="pull-left">
                        <label>
                            <input type="text" v-model.trim="params.keywords" name="keywords" 
                            class="form-control input-sm" placeholder="用户名/账户" >
                        </label>
                    </div>
                    <div  class="pull-left" style="margin-left:10px;">
                        <button type="button" class="btn btn-gray btn-sm" @click="doSearch()"><i
                                        class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="col-xs-2">

                        <button type="button" class="btn btn-turquoise btn-sm" v-if="can('/user/edit')" @click="editUser()"><i
                                        class="fa fa-users"></i>&ensp;新建</button>

                </div>
            </div>


            <vTable
                 ref="table"
                :ajaxUrl="ajaxUrl"
                :params="params"
                :lists="lists"
                :perPage="limit"
                :ths="ths"
                :del="del"
            >
                <template slot="username" slot-scope="items">
                        {{ items.value }}
                </template>
                <template slot="name" slot-scope="items">
                        {{ items.value }}
                </template>
                <template slot="depa" slot-scope="items">
                        {{ items.value ? items.value.name : '' }}
                </template>
                <template slot="created_at" slot-scope="items">
                        {{ items.value }}
                </template>
                <template slot="actions" slot-scope="items">

                        <a href="javascript:void(0);" v-if="can('/user/edit')" @click.prevent="editUser(items.item.user_id)"  class="btn btn-secondary btn-sm btn-icon icon-left">
                            修改
                        </a>
                        
                        <a href="javascript:void(0);"  v-if="can('/user/del')" @click.prevent="$refs.table.onDel(items.item.user_id)" class="btn btn-danger btn-sm btn-icon icon-left">
                            删除
                        </a>
                        
                        <a href="javascript:void(0);" class="btn btn-info btn-sm btn-icon icon-left">
                            详情
                        </a>
                </template> 
            </vTable>
        </div>
    </div>
</div>



</template>


<script>
    import vTable from 'components/common/Table.vue';
    export default {
        components: { vTable },
        data(){
            return {
                lists: [],
                ths: {
                    username: {label: '账号'},
                    name: {label: '姓名'},
                    depa:{label:'部门'},
                    created_at: {label: '创建时间', sortable: true},
                    actions: {label: '操作'}
                },
                ajaxUrl: "/user/list",
                params: {
                    limit: 10,
                    keywords: "",
                },

                del: {  
                    url:'/user/del',
                    title:'确定要删除该用户吗?'
                },
            }
        },
        computed: {
            limit: {
                get() {
                    return this.params.limit;
                },
                set(val){
                    this.$validator.validate().then(result=>{
                        if(result){
                            this.params.limit = val;
                            this.$refs.table.loadList();
                        }
                    });    
                } 
            }
        },
        methods: {
            doSearch() {

                this.$validator.validate().then(result=>{
                    if(result){
                        this.$refs.table.loadList();
                    }
                });  
            },
            editUser(user_id) {

                let url = user_id ? `/user/edit/${user_id}`  : `/user/edit`;

                this.$router.push({ path: url });
            }
        }
    }
</script>