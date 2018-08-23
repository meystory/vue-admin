
//菜单树
export const menuTree = (state,data) => {
   	state.menuTree = data;
}

//当前编辑的节点数据
export const nodeEdit = (state, data) => {
	for(let index in state.nodeEdit)
    {
        state.nodeEdit[index] = (data[index] || data[index] === 0) ? data[index] : state.nodeEdit[index];
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

