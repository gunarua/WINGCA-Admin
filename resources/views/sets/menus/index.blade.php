@extends('layouts.default')
@section('title','菜单管理')
@section('pageHeader','系统设置')
@section('pageSmallHeader','菜单管理')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="btn-group">
                    <button type="button" data-toggle="modal" data-target="#menu-add" class="btn btn-success">添加菜单</button>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                  <!-- 拓展菜单 -->
                    <!-- <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul> -->
                </div>
                <small>&nbsp;&nbsp;&nbsp;&nbsp;Tip: 注意表单展示的时候根据宽度尺寸来隐藏一些显示内容</small>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12">
                        <table id="menus" class="table table-bordered table-hover " >
                            <thead>
                                <tr role="row">
                                    <tr>
                                        <th rowspan="1" colspan="1">#</th>
                                        <th rowspan="1" colspan="1">菜单名称</th>
                                        <th rowspan="1" colspan="1">url</th>
                                        <th rowspan="1" colspan="1">父级栏目id</th>
                                        <th rowspan="1" colspan="1">icon</th>
                                        <th rowspan="1" colspan="1">操作</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($key_data->get('datas') as $v)
                                <tr role="row" >
                                    <td>{{ $v->id }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->url }}</td>
                                    <td>{{ $v->parent_id }}</td>
                                    <td><i class="fa fa-{{ $v->icon }}"></i> {{ $v->icon }}</td>
                                    <td>
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-sm btn-warning" onclick="menu_info( {{ $v->id }} )" data-toggle="modal" data-target="#menu-info">查看</button>
                                          <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" class="del-btn" data-id="{{ $v->id }}" data-toggle="modal" data-target="#menu-del">删除</a></li>
                                          </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $key_data->get('datas')->render() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- 查看/修改 弹窗 -->
<div class="modal fade" id="menu-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">【菜单名称】</h4>
      </div>
      <form method="post" action="{{ route('menus.update') }}">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="modal-body">
            <div class="form-group">
                <input type="hidden" name="id" value="">
            </div>

            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>名称:</label>
                    <input type="text" name="name" class="form-control" placeholder="菜单名称">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>url:</label>
                    <input type="text" name="url" class="form-control" placeholder="填写有效的路径">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>icon: <small><a href="" target="_blank">查看相关的图标列表</a></small></label>
                    <input type="text" name="icon" class="form-control" placeholder="填写图标名称">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>菜单索引：</label>
                    <input type="text" name="name_index" class="form-control" placeholder="填写英文的菜单索引">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>父级栏目:</label>
                    <br>
                    <div class="col-sm-6" style="padding: 0">
                        <select class="js-example-basic-single" id='menu-update-select' name="parent_id">
                          <option value="0">一级栏目</option>
                          @foreach( $key_data->get('parent_data') as $v )
                          <option value="{{ $v->id }}">{{ $v->name }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-success">更新</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- 删除弹窗 -->
<div class="modal fade" id="menu-del">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">警告信息！</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="{{ route('menus.destroy') }}">
          <input type="hidden" name="id" value="">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
        <p>确定删除这个菜单么，相关功能和模型可能无法使用。</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-danger" >确认删除</button>
      </div>
     </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- 添加弹窗 -->
<div class="modal fade" id="menu-add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">添加菜单</h4>
      </div>
      <form method="post" action="{{ route('menus.store') }}">
      {{ csrf_field() }}
      <div class="modal-body">

            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>名称:</label>
                    <input type="text" name="name" class="form-control" placeholder="菜单名称">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>url:</label>
                    <input type="text" name="url" class="form-control" placeholder="填写有效的路径">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>icon: <small><a href="" target="_blank">查看相关的图标列表</a></small></label>
                    <input type="text" name="icon" class="form-control" placeholder="填写图标名称">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>菜单索引：</label>
                    <input type="text" name="name_index" class="form-control" placeholder="填写英文的菜单索引">
                </div>
                <div class="col-sm-1"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <label>父级栏目:</label>
                    <br>
                    <div class="col-sm-6" style="padding: 0">
                        <select class="js-example-basic-single" name="parent_id">
                          <option value="0">一级栏目</option>
                          @foreach( $key_data->get('parent_data') as $v )
                          <option value="{{ $v->id }}">{{ $v->name }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-1"></div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">添加</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>

$('.del-btn').click(function(){
    $('#menu-del').find("input[name='id']").val($(this).data('id'));
});

// 查看菜单项目
let menu_info = function(id){

    $.ajax({
        url: "{{ route('menus.info') }}",
        data: {id: id},
        type: "POST",
        beforeSend: function(){
            $('.pop-background').css('display','flex');
        },
        success: function(data){
            data = JSON.parse(data);
            let option_value = "option[value='"+data.parent_id+"']";
            // let this_option = "option[value='"+id+"']";
            $('#menu-info').find("input[name='id']").val(data.id);
            $('#menu-info').find("input[name='name']").val(data.name);
            $('#menu-info').find("input[name='icon']").val(data.icon);
            $('#menu-info').find("input[name='url']").val(data.url);
            $('#menu-info').find("input[name='name_index']").val(data.name_index);
            // 默认选中option和select2的默认值
            $('#menu-info').find(option_value).attr('selected',true);
            $('#menu-update-select').select2("val",[data.parent_id]);
            // 禁止选中栏目自己本身成为子栏目
            // $('#menu-info').find(this_option).attr('disabled',true);
            // $('#menu-info').find(this_option).select2({disabled: true});
            
            $('.pop-background').css('display','none');
        }
    });
}

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>


@stop
