@extends('layouts.admin-app')

@section('content')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> Dashboard <span>系统设置</span></h2>
    </div>

    <div class="contentpanel">

        <div class="row">

            <div class="col-sm-9 col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="" class="panel-close">×</a>
                            <a href="" class="minimize">−</a>
                        </div>
                        <h4 class="panel-title">添加角色</h4>
                    </div>

                    <form class="form-horizontal form-bordered" action="{{ route('admin.tuser.store') }}" method="POST">

                    <div class="panel-body panel-body-nopadding">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">用户名 <span class="asterisk">*</span></label>

                            <div class="col-sm-6">
                                <input type="text" data-toggle="tooltip" name="username"
                                       data-trigger="hover" class="form-control tooltips"
                                       data-original-title="不可重复" value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">密码</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="passsword"
                                       value="{{ old('passsword') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">确认密码</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="passsword"
                                       value="{{ old('passsword') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">冻结</label>
                            <label class="btn btn-primary">
                                <input type="radio" name="freeze" id="option1" value="1"> &nbsp;是&nbsp;
                            </label>
                            &nbsp;
                            <label class="btn btn-danger">
                                <input type="radio" name="freeze" id="option2" value="0"> &nbsp;否&nbsp;
                            </label>
                        </div>

                        {{ csrf_field() }}
                    </div><!-- panel-body -->

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button class="btn btn-primary">保存</button>
                            </div>
                        </div>
                    </div><!-- panel-footer -->

                    </form>
                </div>

            </div><!-- col-sm-9 -->

        </div><!-- row -->

    </div>
@endsection
