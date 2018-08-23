<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Event;

/**
 * 权限控制器
 */
class PermissionController extends Controller
{	
	public function __construct(PermissionService $permissSer)
	{
		$this->permissSer = new PermissionService();
	}
	/**
	 * 获取节点树
	 */
	public function getNodeTree()
	{
		$tree = $this->permissSer->getNodeTree();
		return self::success('',$tree);
	}

	/**
	 * 新增节点
	 */
	public function addNode()
	{
		$data = request()->all();
		//TODO 表单验证
		$insert = [];
		$insert['title'] = $data['title'];
		$insert['action'] = $data['action'];
		$insert['is_show'] = $data['is_show'];
		$insert['level'] = $data['level'];
		$insert['sort'] = $data['sort'];
		$insert['parent_id'] = $data['parent_id'];

		if(! $permissSer->createNode($insert)){
			return self::error('新增失败');
		}

		//清楚节点缓存,重新获取所有nodeTree
		Event::fire('clear.node');
		$nodeTree = $this->permissSer->getNodeTree();

		//如果新增中存在is_show,更新菜单
		$menuTree = null;
        if($data['is_show'] == 1){
        	$menuTree = $this->permissSer->getMenuTree();
        }

		return self::success('',compact('nodeTree','menuTree'));

	}

	/**
	 * 修改节点
	 */
	public function editNode()
	{
		$data = request()->all();

		$update = [];
		$update['title'] = $data['title'];
		$update['action'] = $data['action'];
		$update['is_show'] = $data['is_show'];
		$update['sort'] = $data['sort'];
		$update['linecons'] = $data['linecons'];

		$where = ['node_id'=>$data['node_id']];
        if(!$this->permissSer->updateNode($where,$update)) {
        	return self::error('修改失败');
        }

        //清楚节点缓存,重新获取所有nodeTree
		Event::fire('clear.node');

		$nodeTree = $this->permissSer->getNodeTree();
		$nodelist = $this->permissSer->getNodeList();
		
		$permissions = array_column($nodelist, 'action');
        $menuTree = null;
        if($data['is_show'] == 1){
        	$menuTree = $this->permissSer->getMenuTree();
        }
        return self::success('修改成功',compact('menuTree','nodeTree','permissions'));
	}

	/**
	 * 删除节点
	 */
	public function delNode()
	{

	}

	/**
	 * 获取角色列表
	 */
	public function getRoleList()
	{	
		$page = request()->get('page',1);
		$list = PermissionService::getRoleList($page);
		return self::success('',compact('list'));
	}

	/**
	 * 
	 */
	public function roleDetail()
	{
		$role_id = request()->get('role_id');

		$role_nodes = $this->permissSer->getRoleNodesById($role_id);
		$role_node_ids = array_column($role_nodes, 'node_id');

		$node_tree = $this->permissSer->getNodeTree();
		return self::success('', compact('role_node_ids','node_tree'));
	}
	/**
	 * 
	 */
	public function addRole()
	{

	}

	/**
	 * 
	 */
	public function editRole()
	{
		
	}


	/**
	 * 删除角色
	 */
	public function delRole()
	{
		
	}
}