<template>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">权限节点树</h3>
    </div>
    <div class="panel-body" style="min-height:500px;">
        <div class="col-sm-8" style="border: 1px solid #d3e0e9;;padding:10px 5px 5px 5px;min-height:10%;">
            <button type="button" class="btn btn-gray btn-sm pull-right" @click="addRootNode()"><i
                                            class="fa fa-plus-square"></i>&ensp;添加根节点</button>
            <ul v-for="nodeItem in nodeTree">
                <child-li :model="nodeItem" ></child-li>                
            </ul>
        </div>
    </div>

    <div class="modal fade" :class="showModal ? 'in show' : '' " role="dialog" tabindex="-1" data-backdrop="static" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" @click="closeModal()">×</button>
                    <h4 class="modal-title">{{ modalData.node_id ? '修改节点':'新增节点' }}</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="control-label">父级节点</label>
                                
                                <input type="text" disabled="disabled" class="form-control" :value="modalData.p_title">
                                <input type="hidden" class="form-control" name="parent_id" :value="modalData.parent_id">
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                            <div class="form-group" :class=" errors.has('title') ? 'has-error': '' ">
                                <label for="" class="control-label">节点名</label>
                                <input type="text" class="form-control" name="title"  v-model.trim="modalData.title"   v-validate="{ required:true, zh_char:[1,10] }" data-vv-as="节点名" autocomplete="off">
                                <span class="help-block">&nbsp;{{ errors.first('title') }}</span>
                            </div>  
                             
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" :class=" errors.has('action') ? 'has-error': '' ">
                                <label for="" class="control-label">节点路由</label>
                                <input type="text" class="form-control"  name="action" v-model.trim="modalData.action"   v-validate="{ required:true, node_action: true }" data-vv-as="节点路由" autocomplete="off">

                                <span class="help-block">&nbsp;{{ errors.first('action') }}</span>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <label for="" class="control-label">是否显示</label>
                                
                                <p>
                                    <label class="cbr-inline" v-for="radioItem in radioDefault ">
                                        <div class="cbr-replaced cbr-primary cbr-radio" :class="{ 'cbr-checked' : modalData.is_show== radioItem.value }" >
                                            <div class="cbr-input">
                                                <input type="radio" name="sex" :value="radioItem.value" v-model="modalData.is_show" class="cbr cbr-done">
                                            </div>
                                            <div class="cbr-state">
                                                <span></span>
                                            </div>
                                        </div>
                                        {{ radioItem.text }}
                                    </label>
                                </p>
                            </div>  
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="" class="control-label">图标</label>
                                <input type="text"  class="form-control" name="linecons" v-model="modalData.linecons">
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="" class="control-label">排序</label>

                                <input type="number" min="0" max="100" class="form-control" name="sort" v-model="modalData.sort">
                            </div>  
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" @click="submitNode()">确定</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade in" v-if="showModal"></div>
</div>
</template>


<script>
    import ChildLi from './ChildLi.vue';
    export default {
        components: {
            'child-li': ChildLi
        },
        data(){
            return {
                radioDefault: [{
                    value: 1,
                    text: '显示',
                },{
                    value: 2,
                    text: '不显示',
                }],

                nodeTree:[],

                
            }
        },
        beforeCreate() {
            //模态数据重置，获取初始值
            this.$store.commit('nodeModalReset');
        },
        created() {
            this.$axios({
                type: 'get',
                url : '/node/list',
                success:function(data){
                    this.nodeTree = data;
                },
                
            });
        },
        computed: {
            modalData() {
                return this.$store.state.nodeModalData;
            },
            showModal() {
                return  this.modalData.modal_show;
            }
        },
        methods: {
            submitNode() {
                let is_edit = this.modalData.node_id ? true : false;
                this.$validator.validate().then(result=>{
                    if(result){
                        let url = is_edit ? '/node/edit' : '/node/add';
                        this.$axios({
                            url : url,
                            data: this.modalData,
                            success:function(data){
                                //重载节点树
                                this.nodeTree = data.nodeTree;
                                if(is_edit) {
                                    //TODO: 更新vuex 当前用户权限列表
                                    this.$store.commit('permissions', data.permissions);
                                }
                                //更新vuex 菜单
                                if(data.menuTree) {
                                    this.$store.commit('menuTree', data.menuTree);
                                }
                                this.closeModal();
                            },
                            
                        });
                    }
                });
            },
            closeModal() {
                this.modalData.modal_show = false;
                this.$store.commit('nodeModalReset');//重置
            },
            addRootNode() {
                //添加根节点。提交初始数据
                this.$store.commit('nodeModalData', { parent_id:0 , modal_show:true, level:1});
            }
        }
    }
</script>