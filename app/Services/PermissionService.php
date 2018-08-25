<?php

namespace App\Services;

use App\Http\Controllers\Common;
use App\Models\Node;
use App\Models\Role;
use Cache;
class PermissionService extends BaseService
{

	/**
	 * 获取节点树
	 */
	public static function getNodeTree()
	{	
		$tree = Cache::get('user_node_tree');
		if(!$tree){
			$list = self::getNodeList();
			$tree = Common::buildTree($list,'node_id');
			Cache::put('user_node_tree', $tree, 120);
		}
		return $tree;
	}

	/**
	 * 获取节点列表
	 */
	public static function getNodeList()
	{
		return Node::where('deleted_at',0)->get()->toArray();
	}

	/**
	 * 获取菜单树
	 */
	public static function getMenuTree()
	{
		$list = Node::where('is_show',1)->where('deleted_at',0)->get()->toArray();
        return Common::buildTree($list,'node_id');
	}

	/**
	 * 新增节点
	 */
	public function createNode($data)
	{
		return Node::create($data);
	}

	/**
	 * 更新节点
	 */
	public function updateNode($where,$data)
	{
		return Node::where($where)->update($data);
	}


	/**
	 * 
	 */
	public static function getRoleList($page,$limit=20)
	{	
		$list = Role::query();

		$list = $list->paginate($limit, ['*'], 'page', $page);
		return $list;
	}
	
	public static function getRoleNodesById($role_id)
	{
		$role = Role::find($role_id);
		if(!$role){
			return [];
		}
		$nodes = $role->nodes()->get();
		return $nodes->toArray();
	}

	public function getRoleNodeTreeById($role_id)
	{	
		$c_key = 'user_node_tree_'.$role_id;
		$tree = Cache::get($c_key);
		if(!$tree)
		{
			$list = self::getRoleNodesById($role_id);
			$tree = Common::buildTree($list,'node_id');
			Cache::put($c_key, $tree, 120);
		}
		return $tree;
	}

	/**
	 * @param int $role 角色id
	 * @param array $role_info 角色基本信息
	 * @param array $role_nodes 角色关联的节点
	 */
	public function updateRole($role_id, $role_info=[] ,$role_nodes)
	{

		if($role_id){
			$role = Role::find($role_id);
		}else{
			$role = Role::create($role_info);
		}

		if(!$role){
			return false;
		}

		//更新角色基本信息
		if($role_info){
			$role->update($role_info);
		}
		//同步节点关系
		$role->nodes()->sync($role_nodes);
		return true;
	}
}