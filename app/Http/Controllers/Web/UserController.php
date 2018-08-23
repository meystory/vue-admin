<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * 用户
 */
class UserController extends Controller
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
     *
     */
    public function getList()
    {   
        $data = request()->all();

        $list = User::with(['depa'=>function($query){
            $query->select('department_id','name');
        }]);

        if(!empty($data['keywords']))
        {
            $list = $list->where('username',$data['keywords'])->orWhere('name',$data['keywords']);
        }

        if(!empty($data['st_filed']))
        {   
            $sort = $data['st_desc'] ? 'desc': 'asc';

            $list = $list->orderBy($data['st_filed'] , $sort);
        }

        $page = empty($data['page']) ? 1 : $data['page'];

        $limit = empty($data['limit']) ? 10 : $data['limit'];

        $list = $list->paginate($limit, ['*'], 'page', $page);

        return self::success('',compact('list'));
    }




    /**
     * 新建/编辑用户
     */
    public function postAdd(UserRequest $request)
    {   
        $data = [
            'username'=> $request->get('username'),
            'name'=> $request->get('name'),
            'mobile'=> $request->get('mobile',1),
            'email'=> $request->get('email',''),
            'sex'=> $request->get('sex',1),
            'depa_id' => $request->get('depa_id',0),
        ];

        //TODO:文件类处理转换为存储url
        $avatar = self::upFile($request->file('avatar'));

        $data['avatar'] = $avatar;

        $user_id = $request->get('user_id');

        if($user_id)
        {   
            $msg = '修改';
            $res = User::where(['user_id'=>$user_id, 'is_admin'=>2])->update($data);
        }else
        {   
            $msg = '新增';
            $data['password'] = bcrypt('123123');
            $res = User::create($data);
        }

        if(!$res)
        {
            return self::error($msg.'失败');
        }
        return self::success($msg.'成功');
    }

    /**
     * 获取用户
     */
    public function info()
    {
        $user_id = request()->get('user_id',0);
        $user = User::find($user_id);
        if(!$user)
        {
            return self::error('用户不存在');
        }
        return self::success('', $user);
    }

    /**
     * 删除
     */
    public function del()
    {
        $user_id = request()->get('user_id');

        $user = User::find($user_id);
        if(!$user)
        {
           return self::error('此用户不存在!'); 
        }

        if($user->is_admin == 1)
        {
            return self::error('此用户无法删除');
        }
        $user->delete();
        return self::success('删除成功');

    }

    public static function upFile($file)
    {   
        // dump($file);
        if(!$file instanceof UploadedFile){
            return '';
        }
        
        
        $extension = $file->getClientOriginalExtension(); // 文件后缀
        $mime_type = $file->getMimeType();  //文件类型

        $new_file_name = date('YmdHis').'.'. $extension;

        $file = $file->move(public_path().'/uploads', $new_file_name);

        if(!$file){
            return false;
        }
        return '/uploads/'.$new_file_name;

        // $clientName = $file->getClientOriginalName();//原文件名
        // $tmpName = $file -> getFileName();  // 临时文件名.tmp

        //方法2
        // $base_img = str_replace('data:image/jpg;base64,', '', $base_img);
        // //  设置文件路径和文件前缀名称
        // $path = "./";
        // $prefix='nx_';
        // $output_file = $prefix.time().rand(100,999).'.jpg';
        // $path = $path.$output_file;
        // //  创建将数据流文件写入我们创建的文件内容中
        // $ifp = fopen( $path, "wb" );
        // fwrite( $ifp, base64_decode( $base_img) );
        // fclose( $ifp );
    }
}
