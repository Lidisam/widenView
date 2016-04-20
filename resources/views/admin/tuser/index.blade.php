@extends('layouts.admin-app')

@section('content')

    <div class="pageheader">
        <h2><i class="fa fa-home"></i> Dashboard <span>客户列表</span></h2>
    </div>

    <div class="contentpanel panel-email">

        <div class="row">
            <div class="col-sm-9 col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="pull-right">
                            <div class="btn-group mr10">
                                <a href="{{ route('admin.tuser.create') }}" class="btn btn-white tooltips"
                                   data-toggle="tooltip" data-original-title="新增"><i
                                            class="glyphicon glyphicon-plus"></i></a>
                                <a class="btn btn-white tooltips deleteall" data-toggle="tooltip"
                                   data-original-title="删除" data-href="{{ route('admin.tuser.destory.all') }}"><i
                                            class="glyphicon glyphicon-trash"></i></a>
                            </div>
                        </div><!-- pull-right -->

                        <h5 class="subtitle mb5">用户列表</h5>


                        <div class="table-responsive col-md-12">
                            <table class="table mb30">
                                <thead>
                                <tr>
                                    <th>
                                        <span class="ckbox ckbox-primary">
                                            <input type="checkbox" id="selectall"/>
                                            <label for="selectall"></label>
                                        </span>
                                    </th>
                                    <th>用户名</th>
                                    <th>头像链接</th>
                                    <th>冻结</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_infos as $user_info)
                                    <tr>
                                        <td>
                                            <div class="ckbox ckbox-default">
                                                <input type="checkbox" name="id" id="{{ $user_info->id }}"
                                                       value="{{ $user_info->id }}" class="selectall-item"/>
                                                <label for="{{ $user_info->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $user_info->username }}</td>
                                        <td>{{ $user_info->interlink }}</td>
                                        <td><span class="label label-danger">是</span>
                                            <!-- ':'<span class="label label-default">否</span> -->
                                        </td>
                                        <td>{{ $user_info->created_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.tuser.edit',['id'=>$user_info->id]) }}"
                                               class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                            <a class="btn btn-danger btn-xs user-delete"
                                               data-href="{{ route('admin.tuser.destroy',['id'=>$user_info->id]) }}">
                                                <i class="fa fa-trash-o"></i> 删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $user_infos->render() !!}

                    </div><!-- panel-body -->
                </div><!-- panel -->

            </div><!-- col-sm-9 -->

        </div><!-- row -->

    </div>
@endsection

@section('javascript')
    @parent
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script type="text/javascript">
        $(".user-delete").click(function () {
            Rbac.ajax.delete({
                confirmTitle: '确定删除用户?',
                href: $(this).data('href'),
                successTitle: '用户删除成功'
            });
        });

        $(".deleteall").click(function () {
            Rbac.ajax.deleteAll({
                confirmTitle: '确定删除选中的用户?',
                href: $(this).data('href'),
                successTitle: '用户删除成功'
            });
        });
    </script>

@endsection
