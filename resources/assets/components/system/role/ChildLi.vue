<template>
<li class="col-md-12" >
    <span class="pull-left" @click="toggleOpen()" style="color: #2c2e2f;width:16.44px;margin-right: 5px;">
        <i v-if="isFolder" :class="( this.open ? 'fa-caret-down' : 'fa-caret-right' )" ></i>
    </span>
    <label >
        <input type="checkbox" :disabled="!canCheck" v-model="checkedIds"  :value="model.node_id" @change="toggleCheck($event)" />

        <span style="color: #2c2e2f;">{{model.title}}</span>
    </label>
    
    <ul v-show="open" v-if="isFolder" style="padding-left: 50px;">  
    	<el-tree  @emitParent="receiveChild"  ref="child-tree" v-for="item in model.child" :model="item"  :key="item.id" :canCheck="canCheck"></el-tree> 
    </ul>
</li>
</template>
<style lang="scss" type="text/css">
li { 
    list-style-type:none;
    margin: 2px 0;
    
    span { 
        :hover {cursor: pointer; }
        padding-right: 5px;
    }
    .no-folder {
        display: block;
        float: left;
        width: 25px;
    }
    .set-icon{
    	margin-left:20px;
    	position: relative;
        &:hover{
            .set-option{ display: block;}
        }
        
    }
    div.set-option{
        display: none;
    	position:absolute;
    	left:7px;
    	top:10px;
    	border: 1px solid #e6e3e4;
    	width: 80px;
    	padding: 5px;
        background: #fff;
        z-index: 100;
        div.text-gray { padding: 1px; text-align: center;}
    	div.text-gray:hover {
            cursor: pointer;
    		background: #e6e3e4;
    		
    	}
    }
    i[class*="fa-"]{ font-size:20px; vertical-align: middle;}
    .node-content{ font-size:15px;}
}
</style>
<script type="text/javascript">
	export default {
		name: 'el-tree',
        props: {
            model: {
                default:()=>{}
            },
            canCheck: {
                type: Boolean,
                default: true,
            }
        },
		data() {
			return {
				open: true,
			}
		},
		computed: {
			isFolder() {

				return this.model.child && this.model.child.length;
			},
            checkedIds: {
                get() {
                    return this.$store.state.checkNodes;
                },
                set(value) {
                    this.$store.commit('checkNodes' ,value);
                }
            }
		},
		methods: {
            toggleOpen() {
                this.open = !this.open;
            },
            toggleCheck(e) {

                let checked = e.target.checked;
                
                //向下分发通知
                if(this.$refs['child-tree']){
                    this.$refs['child-tree'].forEach((childVm)=>{
                        childVm.emitChild(checked);
                    });
                }
                //向上分发通知
                this.$emit('emitParent');

            },
            emitChild(checked) {
                //重置下级选中状态
                this.resetCheck(checked);

                if(this.model.child.length>0){
                    //继续递归
                    this.$refs['child-tree'].forEach((childVm)=>{
                        childVm.emitChild(checked);
                    });
                }
            },
            resetCheck(checked) {
                let index = this.checkedIds.indexOf(this.model.node_id);
                //当前model取消选中
                if(!checked && index !== -1){
                    this.checkedIds.splice(index,1); //否则会出现splice(-1,1)的问题
                }

                //当前model选中
                if(checked && index === -1){
                    this.checkedIds.push(this.model.node_id);
                }
            },
            receiveChild() {
                //接收子级的通知
                //判断当前model中,子级选中的个数
                let childChecked = 0;
                for(let v of this.model.child){
                    if(this.checkedIds.indexOf(v.node_id) !== -1){
                        childChecked ++;
                    }
                }
                //根据子节点选择状态，重置当前model选中状态
                this.resetCheck(childChecked);
                // //递归上分发通知
                this.$emit('emitParent');
            },
		}

	}
</script>