
//菜单树
export const menuTree = (state,data) => {
   	state.menuTree = data;
}

//当前编辑的节点数据
export const nodeModalData = (state, data) => {
	for(let index in state.nodeModalData)
    {
        state.nodeModalData[index] = (data[index] || data[index] === 0) ? data[index] : state.nodeModalData[index];
    }
}
//重置节点编辑模态数据
export const nodeModalReset = (state) => {
	state.nodeModalData  = {
        node_id: null,
        p_title : '根节点',
        title: '',
        action:'',
        parent_id: null,
        is_show: 2,
        level: null,
        linecons: '',
        sort: 50,
        modal_show: false,
    }
}
//当前用户所有权限列表
export const permissions = (state,data) => {
   	state.permissions = data;
}


//角色权限选择
export const checkNodes = (state,data) => {
	state.checkNodes = data;
}

