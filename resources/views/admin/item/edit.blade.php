@extends('layouts.admin-app')
@section('title', '项目配置')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ url('plugins/jquery.Jcrop.css') }}"/>
    <link rel="stylesheet" href="{{ url('plugins/style.css') }}"/>
    <link rel="stylesheet" type="text/css" href="/../js/umeditor/themes/default/css/umeditor.min.css"/>
    <link rel="stylesheet" href=" {{url('css/main.css')}}">
    <style type="text/css">
        .edui-container{width:100%!important}
        .edui-body-container{min-height:120px!important}
        input:-ms-input-placeholder{font-size:14px}
        input::-webkit-input-placeholder{font-size:14px}
        input::-moz-placeholder{font-size:14px}
        input:-moz-placeholder{font-size:14px}
        .edui-toolbar {display: none;}
        .searchable-select-items{max-height: 190px;}
        #Validform_msg {display: none;}
    </style>
@endsection

@section('content')

    <div class="dh-main">
        <div class="am-g">
            <div class="am-u-sm-3 am-u-md-3 am-u-lg-2 bgfff" id="leftNav">
                <!--左侧菜单-->
                @include('admin._partials.item-left-menu')
            </div>
            <div class="am-u-sm-9 am-u-md-9 am-u-lg-10" id="rightMain">
                <div class="dh-main-container">
                    <p class="title"><a href="{{ route('item.index') }}"><i class="iconfont">&#xe604;</i></a>编辑项目配置
                        <!--<button id="editformsub" type="submit" class="am-fr am-btn am-btn-primary br5px">保存</button>-->
                    </p>
                    <div class="bgfff porject-modal am-text-center" style="cursor: pointer;">
                        <div class="text-center">
                            <div id="validation-errors"></div>
                            <div class="uploadimgbtn-box"  id="uploadimgbtn">
                                <div class="ceng">
                                    <div>图片</div>
                                    <div>上传</div>
                                </div>
                                <img src="{{ $item->images ? $item->images->url : url('images/dhproject.png')}}" />
                            </div>
                            {!! Form::open(['url'=>route('item.image.upload',[$item->id]),'files'=>true,'id'=>'avatar']) !!}
                            <div class="text-center am-hide">
                                <button id="uploadbtn" type="button" class="btn btn-success avatar-button" did="upload-avatar">上传新的头像</button>
                            </div>
                            {!! Form::file('img',['class'=>'avatar','id'=>'image']) !!}
                            {!! Form::close() !!}
                            <div class="span5">
                                <div id="output" style="display:none">
                                </div>
                            </div>
                        </div>
                        <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
                            <ul class="am-tabs-nav am-nav am-nav-tabs">
                                <li class="am-active">
                                    <a href="#tab1">项目信息</a>
                                </li>
                                <li>
                                    <a href="#tab2">成员管理</a>
                                </li>
                            </ul>
                            <div class="am-tabs-bd">
                                <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                                    <form id="editform" class="am-form am-form-horizontal" method="post">
                                        <input type="hidden" value="{{ $item->hands->id }}" id="handid">
                                        <input type="hidden" value="{{ $item->id }}" id="item_id">
                                        <fieldset>
                                            <div class="am-form-group">
                                                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">项目名称</label>
                                                <div class="am-u-sm-10">
                                                    <input name="name" type="text" id="itemname" id="doc-ipt-3" placeholder="最多可以输入50个字符" value="{{ $item->hands->name }}">
                                                </div>
                                            </div>
                                            <div class="am-form-group">
                                                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">项目描述</label>
                                                <div class="am-u-sm-10">
                                                    <script type="text/plain" id="myEditor" class="am-text-left">{!! html_entity_decode(stripslashes($item->hands->description)) !!}</script>
                                                    {{--<textarea name="description" class="minheight-md br5px" id="doc-ta-1" placeholder="最多可以输入500个字符">{{ $item->hands->description }}</textarea>--}}
                                                </div>
                                            </div>
                                            @if(Entrust::can('item.hand.edit'))
                                                <p class="am-text-left am-u-sm-10 am-u-sm-offset-2">
                                                    <button id="itemsave_btn" type="button" class="am-btn am-btn-secondary br5px">保存</button>
                                                </p>
                                            @endif
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="am-tab-panel am-fade" id="tab2" style="min-height: 360px">
                                    <div>
                                        <p class="addp-title">添加成员</p>
                                        <form>
                                            <div class="am-u-sm-10">
                                                <select class="addcy" id="addcy">
                                                    @foreach($adminUsers as $adminUser)
                                                        <option value="{{ $adminUser->id }}">{{ $adminUser->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="am-u-sm-2">
                                                @if(Entrust::can('item.addTeamer'))
                                                    @if(Auth::guard('admin')->user()->id == $item->fid || $item->create_id || 23)
                                                        <input id="addcybtn" type="button" class="am-btn am-btn-secondary br5px" value="添加"/>
                                                    @endif
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                    <div style="clear: both;"></div>
                                    <p class="addp-title">成员列表</p>
                                    <div class="paddlr20px" id>
                                        <div class="am-fl am-text-left" id="creater">
                                            <div>{{ $creater->name }}{{ $item->office }}</div>
                                            <span class="color888">{{ $creater->email }}</span>
                                        </div>
                                        <div class="am-fr paddt10px"><span class="">项目创建者</span></div>
                                        <div style="clear: both;"></div>
                                    </div>
                                    <ul id="listBox">
                                        @foreach($admin_users as $admin_user)
                                            @if($item->fid == $admin_user->id)
                                                <li class="list-child paddlr20px">
                                                    <div class="am-fl am-text-left">
                                                        <div>{{ $admin_user->name }}({{ $admin_user->display_name }})
                                                        </div>
                                                        <span class="color888">{{ $admin_user->email }}</span>
                                                    </div>
                                                    <div class="am-fr paddt10px">
                                                        @if(Entrust::can('item.delete.master'))
                                                            @if(Auth::guard('admin')->user()->id == $item->create_id || 23  )
                                                                <span class="sbtn2 colorred" onclick="setdf(this)" name="{{ $admin_user->id }}">移除</span>
                                                            @endif
                                                        @endif
                                                        <span class="">总负责人</span></div>
                                                    <div style="clear: both;"></div>
                                                </li>
                                            @else
                                                <li class="list-child paddlr20px">
                                                    <div class="am-fl am-text-left">
                                                        <div>{{ $admin_user->name }}({{ $admin_user->display_name }})
                                                        </div>
                                                        <span class="color888">{{ $admin_user->email }}</span>
                                                    </div>
                                                    <div class="am-fr paddt10px">
                                                        @if(Entrust::can('item.add.master'))
                                                            @if(Auth::guard('admin')->user()->id == $item->create_id || 23  )
                                                                <span class="sbtn1 color639" onclick="setz(this)" name="{{ $admin_user->id }}">设置为总负责人</span>
                                                            @endif
                                                        @endif

                                                        @if(Entrust::can('item.delete.master'))
                                                            @if(Auth::guard('admin')->user()->id == $item->fid || $item->create_id || 23)
                                                                <span class="sbtn2 colorred" onclick="setdf(this)"name="{{ $admin_user->id }}">移除</span>
                                                            @endif
                                                        @endif

                                                        <span class="">成员</span></div>
                                                    <div style="clear: both;"></div>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <p class="color888 am-text-left fs14 paddlr20px">把鼠标放到列表上显示更多操作</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--裁剪模态框--}}
        <div  class="am-modal am-modal-no-btn" id="doc-modal-1">
            <div class="am-modal-dialog modalwidth-sm">
                <div class="am-modal-hd">
                    <span class="am-fl"><i class="iconfont color639 ">&#xe610;</i>裁剪头像</span>
                    <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                </div>
                <div class="am-modal-bd rights-modal am-margin-top">
                    <div class="lindiv"></div>
                    {!! Form::open( [ 'url' => route('item.image.crop',[$item->id]), 'method' => 'POST', 'onsubmit'=>'return checkCoords();','files' => true ] ) !!}
                    <div class="modal-body">
                        <div class="content">
                            <div class="crop-image-wrapper">
                                <img src="{{ $item->images ? $item->images->url : url('images/dhproject.png')}}" height="300" width="300"  id="cropbox" >
                                <input type="hidden" id="photo" name="photo" />
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <button  class="am-btn am-btn-secondary br5px am-margin-top"  data-am-modal-close>取消</button>
                        <button type="submit" class="am-btn am-btn-secondary br5px am-margin-top">裁剪头像</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <script src=" {{ url('js/umeditor/third-party/template.min.js') }}" type="text/javascript" charset="utf-8" ></script>
    <script src="{{ url('js/umeditor/umeditor.config.js')  }}" type="text/javascript" charset="utf-8"></script>
    <script src=" {{ url('js/umeditor/umeditor.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{url('js/searchableSelect/jquery.searchableSelect.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ url('plugins/jquery.form.js') }}"></script>
    <script src="{{ url('plugins/jquery.Jcrop.min.js') }}"></script>
    <script src=" {{ url('js/main.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        //实例化编辑器
        var um = UM.getEditor('myEditor');
        //获取富文本编辑内容（带格式）
        var handid = $("#handid").val();
        var item_id = $("#item_id").val();
        {{--保存项目信息--}}
        $("#itemsave_btn").click(function (e) {
            var name = $("#itemname").val();
            var description = UM.getEditor('myEditor').getContent();
            var url = '/admin/item/update_item/'+ handid;
            AjaxJson(url,{
                name:name,
                description:description
            },function (data) {
                if(data.status == 1){
                    layer.msg(data.msg);
                    window.location.reload();
                }else {
                    layer.msg(data.msg)
                }
            })
        });
        
        $(".addcy").searchableSelect();
        $("#editform").Validform({
            ajaxPost: true, //true用ajax提交，false用form方式提交
            tipSweep: true, //true只在提交表单的时候开始验证，false每输入完一个输入框之后就开始验证
            //ajax提交完之后的回调函数
            callback: function (data) {
                if (data.status == 1) {
                    layer.msg(data.msg);
//				window.location.reload();
                }
            }
        });

        var url = '/admin/item/addTeamer/' + handid;
        $("#addcybtn").click(function () {
            var admin_user_id = $("#addcy").val();
            AjaxJson(url, {'admin_user_id': admin_user_id}, function (data) {
                if (data.status == 1) {
                    //插入html代码到添加成员的列表
                    $(".searchable-select-holder").html("");
                    $("#listBox").html(data.listhtml);
                    //添加成员之后，要刷新被选成员下拉框内的成员列表
                    console.log(data);
                    $("#addcy").html(data.optionhtml);
//				移除原有节点
                    $(".searchable-select").remove()
//				重新实例化
                    $(".addcy").searchableSelect();
                    layer.msg(data.msg);
                }
            });
        });

        //设置总负责人
        //    onclick="setz(this)"    需要在循环出来的span上加上  name  和onclick属性
        function setz(e) {
            var id = $(e).attr("name");
            var url = '/admin/item/'+item_id+'/add/admin_user/' + id;
            AjaxJson(url, {}, function (data) {
                if (data.status == 1) {
                    //设置完之后刷新成员列表
                    $("#listBox").html(data.listhtml);
                    layer.msg(data.msg);
                }
            });
        }
        //移除成员
        //    onclick="setdf(this)"
        function setdf(e) {
            var id = $(e).attr("name");
            var url = '/admin/item/'+item_id+'/delete/admin_user/' + id;
//        alert(id)
            AjaxJson(url, {}, function (data) {
                if (data.status == 1) {
                    // 移除后在下拉框里要重新刷新可添加的成员
                    $("#addcy").html(data.optionhtml);
                    //移除后成员的列表
                    $("#listBox").html(data.listhtml);
                    //移除原有节点
                    $(".searchable-select").remove()
                    //重新实例化
                    $(".addcy").searchableSelect();
                    layer.msg(data.msg);
                }
            });
        }

        /*上传图片*/
        $("#uploadimgbtn").click(function () {
            $("#image").click();
        })
        $(document).ready(function() {
            var options = {
                beforeSubmit:  showRequest,
                success:       showResponse,
                dataType: 'json'
            };
            $('#image').on('change', function(){
                $('#upload-avatar').html('正在上传...');
                $('#avatar').ajaxForm(options).submit();
            });
        });

        function showRequest() {
            $("#validation-errors").hide().empty();
            $("#output").css('display','none');
            return true;
        }

        function showResponse(response)  {
            if(response.success == false)
            {
                var responseErrors = response.message;
                layer.msg(responseErrors);
                window.location.reload();
            } else {
                $('#doc-modal-1').modal();

                var cropBox = $("#cropbox");
                cropBox.attr('src',response.url);
                $('#photo').val(response.url);

                cropBox.Jcrop({
                    allowMove : true,
                    aspectRatio: 1,
                    onSelect: updateCoords,
                    setSelect: [140,140,10,10]
                });

                $('.jcrop-holder img').attr('src',response.url);
                $('#user-avatar').attr('src',response.url);
                $('#upload-avatar').html('更换新的头像');

            }
        }

        //添加的两个function
        function updateCoords(c)
        {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        }

        function checkCoords()
        {
            if (parseInt($('#w').val())) return true;
            alert('请选择图片.');
            return false;
        }
    </script>
@endsection