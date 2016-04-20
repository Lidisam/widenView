<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tuser\TuserRequest;
use App\Http\Requests\Admin\Tuser\CreateRequest;

use App\Tuser;

use Toastr, Breadcrumbs;

class TuserController extends BaseController
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
	* @desc 获取首页数据
    */
    public function index() {
    	return view('admin.tuser.index', ['user_infos'=>Tuser::paginate(1)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Tuser::find($id);
        return view('admin.tuser.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TuserRequest $request, $id)
    {
        $user = Tuser::find($id);
        $user->username = $request->username;
        $result = $user->save();
        if(!$result) {
            Toastr::error($result['msg']);
        } else {
            Toastr::success('角色更新成功');
        }
        return redirect(route('admin.tuser.edit', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json((Tuser::destroy($id)) ? ['status' => 1] : ['status' => 0]);
    }
    /**
     * Delete multi roles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function destoryAll(Request $request)
    {
        if(!($ids = $request->get('ids', []))) {
            return response()->json(['status' => 0, 'msg' => '请求参数错误']);
        }

        foreach ($ids as $id) {
            $result = Tuser::destroy($id);
        }
        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tuser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $result = Tuser::create($request->all());
        if(!$result) {
            Toastr::error('新角色添加失败!');
            return redirect('admin/tuser/create');
        } else {
            Toastr::success('新角色添加成功!');
            return redirect('admin/tuser');
        }
    }
}
