<?php

namespace App\Services;

use App\Models\User;

class UserService 
{
	
	/**
	 * 获取user信息
	 * @param int $user_id
	 * @param str $relate
	 */
	public function getInfo($user_id,$relate='')
	{
		$user = User::query();
		if($relate) {
			$user = $user->with($relate);
		}
		return $user->find($user_id);
	}

	/**
	 * 
	 */
	public function getList($param, $limit = 20)
	{
		$list = User::with(['depa'=>function($query){
            $query->select('department_id','name');
        }]);

        if(!empty($param['keywords']))
        {
            $list = $list->where('username',$param['keywords'])->orWhere('name',$param['keywords']);
        }

        if(!empty($param['st_filed']))
        {   
            $sort = $param['st_desc'] ? 'desc': 'asc';

            $list = $list->orderBy($param['st_filed'] , $sort);
        }

        $page = empty($param['page']) ? 1 : $param['page'];

        return $list->paginate($limit, ['*'], 'page', $page);
	}

	public function updateUser($user_id,$data)
	{	
		if($user_id){
			$res = User::where(['user_id'=>$user_id])->update($data);
		}
		else{
			$data['password'] = bcrypt('123456');
        	$res = User::create($data);
		}
		return $res;
	}

	public function delUser($user_id)
	{
		return User::where('user_id', $user_id)->where('is_admin',2)->delete();
	}


}