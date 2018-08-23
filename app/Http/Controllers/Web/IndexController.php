<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use App\Models\Node;
use Illuminate\Http\Request;

/**
 * 首页
 */
class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $auth = auth()->user();
        $api_token = 'Bearer '.$auth->api_token;
        //菜单节点
        $list = Node::where('title','!=','')->where('deleted_at',0)->get();
        $permissions = json_encode(array_column($list->toArray(), 'action'));

        //去掉不显示的菜单
        $list = $list->where('is_show',1)->where('deleted_at',0)->toArray();
        $tree = Common::buildTree($list,'node_id');
        $menuTree = json_encode($tree);

        //user信息
        $auth = json_encode([
                'user_id'=> $auth->user_id,
                'username'=> $auth->username,
                'avatar' => $auth->avatar,
            ]);

        return view('index',compact('permissions','menuTree','auth','api_token'));
    }
}
