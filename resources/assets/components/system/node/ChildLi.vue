<template>
<li class="">
    <span class="pull-left" @click="toggle()" style="color: #2c2e2f;">

        <i v-if="isFolder" :class="( this.open ? 'fa-caret-down' : 'fa-caret-right' )" ></i>
        <span v-else class="no-folder"> {{ model.level !=3 ? '×' :'&ensp; ' }}&nbsp;</span>
        <span style="color: #2c2e2f;">{{model.title}}</span>
    </span>
    <div class="" style="padding:0 4px;">
        
        <span class="set-icon" >
            <i class="fa-cog" style="font-size:15px;margin-top:-3px;"></i>
            <div class="set-option">
            	<div class="text-gray" @click="editNode('add')" v-if=" model.level<3 ">添加节点</div>
                <div class="text-gray" @click="editNode('edit')">修改节点</div>
            	<div class="text-gray" @click="delNode()">删除节点</div>
            </div>
        </span>
    </div>
    <ul v-show="open" v-if="isFolder">  

    	<el-tree v-for="item in model.child" :model="item" :p_title="model.title" :key="item.id" ></el-tree> 
    </ul>
</li>
</template>
<style lang="scss" type="text/css">
li { 
    list-style-type:none;
    margin: 5px 0;
    
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
		props:['model','p_title'],
		data() {
			return {
				open: true,
			}
		},
		mounted() {

		},
		computed: {
			isFolder() {
				return this.model.child && this.model.child.length
			}
		},
		methods: {
            toggle() {
                this.open = !this.open;
            },
            delNode() {
                let params = { node_id: this.model.node_id, parent: this.model.parent};
            },
            editNode(type) {
            	let initData;
            	if(type == 'add') {
            		 initData = {
            			parent_id : this.model.node_id,
            			level: parseInt(this.model.level)+1,
            			p_title: this.model.title,
    				};
            	}
            	if(type == 'edit') {
            		initData = this.model;
            		initData.p_title = this.p_title;
            	}
            	initData.modal_show = true;
    			//通过vuex 来实现,提交给modal的数据
    			this.$store.commit('nodeModalData', initData);
            }
		}

	}
</script>