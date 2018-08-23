<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function success($msg = '操作成功', $data = [])
    {
    	$json = [];
    	$json['msg'] = $msg;
    	$json['status'] = 1;
    	$json['data'] = $data;

    	return response()->json($json,200);
    } 

    public static function error($msg = '操作失败', $data = [])
    {
    	$json = [];
    	$json['msg'] = $msg;
    	$json['status'] = -1;
    	$json['data'] = $data;

    	return response()->json($json,200);
    } 

    /**
     * 表单验证错误信息
     */
    public static function verror(array $error= [])
    {
    	//统一为422 Http状态
    	return response()->json($error,422);
    } 
}
