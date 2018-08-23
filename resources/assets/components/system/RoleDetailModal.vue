<template>
<div>
	<div class="modal custom-width fade" :class="showModal ? 'in show' : '' " role="dialog" tabindex="-1" data-backdrop="static" >
        <div class="modal-dialog" role="document" style="width: 40%;">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h4 class="modal-title">权限详情</h4>
                </div>
                
                <div class="modal-body">
                <!-- 静态树 -->
                	<ul v-for="nodeItem in nodeTree">
		                <child-li  :model="nodeItem" :canCheck="false"></child-li>                
		            </ul>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" @click="closeModal()">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade in" v-if="showModal"></div>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">
	import ChildLi from './ChildLi.vue';
	export default {
		components: { 
			'child-li': ChildLi 
		},
		data() {
			return {
				nodeTree: [],
				showModal: false,
			}
		},
		watch: {
			showStatus(val,old){
				console.log(val,old)
				if(this.showStatus === true){
					this.loadTree(this.role_id)
				}
			}
		},
		methods: {
			closeModal() {
				this.showModal = false;
				this.nodeTree = [];
			},
			loadTree(role_id) {
				this.$axios({
					data:{role_id:role_id},
					url: '/role/detail',
					success:function(data){
						this.nodeTree = data.node_tree;
                    	this.$store.commit('checkNodes', data.role_node_ids);
						this.showModal = true;
					}
				});
			}
		}

	}
</script>