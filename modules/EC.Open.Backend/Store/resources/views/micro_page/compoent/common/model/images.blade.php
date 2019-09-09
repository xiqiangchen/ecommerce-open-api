@extends('store-backend::micro_page.bootstrap_modal')

<style>
    .b{
        margin-left: 800px;
    }
</style>


@section('modal_class')
    modal-md b
@stop


@section('title')
    自定义
@stop


@section('after-styles-end')
    {!! Html::style(env("APP_URL").'/assets/backend/libs/ladda/ladda-themeless.min.css') !!}
@stop


@section('body')

    <div class="panel-body">

        <input id="index" type="hidden" name="index" value="{{request('index')}}" class="form-control" placeholder=""
               style="margin-bottom: 10px;margin-top: 10px;">

        <input  type="text" id="group_name" name="group_name" value="{{request('title')}}" class="form-control" placeholder="分组名称"
               style="margin-bottom: 10px;margin-top: 10px;margin-left: 12px;width:520px;">

        <div class="form-group advert">
            {{--<label class="col-sm-2 control-label text-right"></label>--}}

            <div class="col-sm-11 col-lg-11 advert-box">
                <ul id="bar-img" style="margin-left: -50px;max-height: 500px;

    overflow-x: hidden;
    overflow-y: auto;" >

                    @if(request('input'))

                            @foreach(json_decode(request('input')) as $key=> $item)
                                <li class="advert_li advert_li_ clearfix advert_li_{{$key+1}}" index="{{$key+1}}">
                                    <div class="del">
                                        <i class="fa fa-remove"></i>
                                    </div>
                                    <div class="box_img upload-{{$key+1}}">
                                        <div class="img-upload img-upload-init" >
                                            <div class="box_img">
                                                <img width="88" height="88" src="{{$item->image}}" alt="">
                                                <div class="replace_img">
                                                    <span>更换图片</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="upload">
                                        </div>
                                    </div>

                                    <div class="box_input_group">

                                         <div class='box_input_name'>
                                               <label class="text-right">名称:</label>
                                               <input class='form-control inputName' type='text' name='name'
                                                      placeholder='前端显示的名称' value='{{$item->name}}'>
                                         </div>

                                        <div class='box_input'>

                                            <label class="text-right">链接:</label>

                                            <select class="form-control type-s" name="type">
                                                <option value=0>——请选择链接类型——</option>
                                                <option value="store_detail" @if($item->type=='store_detail') selected  @endif    data-page="/pages/store/detail/detail?id=">商品详情页</option>
                                                <option value="store_list"   @if($item->type=='store_list') selected  @endif  data-page="/pages/store/list/list?c_id=">商品分类页</option>
                                                <option value="store_seckill" @if($item->type=='store_seckill') selected  @endif data-page="/pages/store/seckill/seckill">秒杀列表页</option>
                                                <option value="store_groups"  @if($item->type=='store_groups') selected  @endif  data-page="/pages/store/groups/groups">拼团列表页</option>
                                                <option value="store_callList"  @if($item->type=='store_callList') selected  @endif  data-page="/pages/store/callList/callList">集CALL列表页</option>
                                                <option value="store_mealList"  @if($item->type=='store_mealList') selected  @endif data-page="/pages/store/mealList/mealList">套餐列表页</option>
                                                <option value="other_micro" @if($item->type=='other_micro') selected  @endif data-page="/pages/index/microPages/microPages?id=">微页面</option>
                                                <option value="other_links"  @if($item->type=='other_links') selected  @endif data-page="/pages/other/links/links?url=">公众号文章</option>
                                                <option value="other"  @if($item->type=='other') selected  @endif data-page="other">自定义</option>
                                            </select>

                                        </div>


                                        <div class='box_input link-input'

                                             @if(!in_array($item->type,['store_list','store_detail','other_micro','other_links','other']))

                                             style="display: none"

                                                @endif
                                        >

                                            <label class="link-type text-right"></label>

                                            <input type="text" class="form-control  inputLink inputLink-{{$key+1}}"  data-index="{{$key+1}}"

                                                   @if(in_array($item->type,['store_list','store_detail','other_micro']))

                                                   value="{{strtolower(trim(substr(strrchr($item->link, '='), 1)))}}" disabled

                                                   @elseif($item->type=='other_links')

                                                   value="{{strtolower(trim(substr(strrchr($item->link, '='), 1)))}}"

                                                   @elseif($item->type=='other')

                                                   value="{{$item->link}}"

                                                   @else

                                                   @endif

                                                   data-page="{{config('ibrand.advert.type.'.$item->type.'.page')}}"

                                                   name="link"  data-type="{{$item->type}}" placeholder=""/>

                                        </div>


                                    </div>


                                </li>
                            @endforeach
                        @endif




                </ul>


                <ul>
                    <li class="advert_b_li">
                        <a class="fa fa-plus">
                            <span onclick="add('bar-img',compoent_images_html)">  添加</span>
                        </a>
                    </li>
                    <p style="margin-left: -35px;">*拖动可更改图片位置</p>
                </ul>

            </div>

        </div>

    </div>


@stop

@section('footer')
    <script src="https://cdn.bootcss.com/Sortable/1.6.0/Sortable.min.js"></script>
    <button type="button" class="btn btn-link" data-dismiss="modal" onclick="cancel();">取消</button>
    <button type="button" onclick="saveImg();" class="ladda-button btn btn-primary"> 确定

        <script>
            var compoent_images_html = ["  <li class=\"advert_li advert_li_ clearfix\">",
                "                                <div class=\"del\">",
                "                                    <i class=\"fa fa-remove\"></i>",
                "                                </div>",
                "                                 <div class=\"box_img\">",
                "                                    <div class=\"img-upload\">",
                "                                        ",
                "                                    </div>",
                "                                    <div class=\"upload\">",
                "                                        <i class=\"fa fa-plus add-img\">",
                "                                        </i>",
                "                                    </div>",
                "                                </div>",
                "                                <div class=\'box_input_group\'>",
                "                                <div class=\'box_input_name\'>",
                "                                     <label class=\"text-right\">名称:</label>",
                "                                     <input class='form-control inputName' type='text' name='name' placeholder='前端显示的名称' value=''>",
                "                                </div>",
                "                                <div class=\'box_input\'>",
                "                                     <label class=\"text-right\">链接:</label>",
                "                                    <select class=\"form-control type-s\" name=\"type\">",
                "                                        <option value=0>——请选择链接类型——</option>",
                "                                        <option value=\"store_detail\" data-page=\"/pages/store/detail/detail?id=\">商品详情页</option>",
                "                                        <option value=\"store_list\" data-page=\"/pages/store/list/list?c_id=\">商品分类页</option>",
                // "                                        <option value=\"store_seckill\" data-page=\"/pages/store/seckill/seckill\">秒杀列表页</option>",
                // "                                        <option value=\"store_groups\" data-page=\"/pages/store/groups/groups\">拼团列表页</option>",
                // "                                        <option value=\"store_callList\" data-page=\"/pages/store/callList/callList\">集CALL列表页</option>",
                // "                                        <option value=\"store_mealList\" data-page=\"/pages/store/mealList/mealList\">套餐列表页</option>",
                "                                        <option value=\"other_micro\" data-page=\"/pages/index/microPages/microPages?id=\">微页面</option>",
                "                                        <option value=\"other_links\" data-page=\"/pages/other/links/links?url=\">公众号文章</option>",
                "                                        <option value=\"other\" data-page='other'>自定义</option>",
                "                                    </select>",

                "                                </div>",
                "                                     <div class=\'box_input link-input\' style=\"display: none\">",
                "                                           <label class=\"link-type text-right\"></label>",
                "                                           <input type=\"text\" class=\"form-control inputLink  \" value=\"\" name=\"link\"  data-index=\"\"   data-type=\"\" data-page=\"\"  disabled  placeholder=\"\"/>",
                "                                     </div>",
                "                               </div>",
                "                            </li>"].join("");

            window.box_index = null;


            $(function () {
                var length = $('.advert_li').length;
                $('.advert_li').each(function (val, index) {
                    var num = $(this).attr('index');
                    uploadImg('.upload-' + num, num, 'edit');
                })
                // // 设置值
                // sessionStorage.setItem('key_a', 1);
                // // 取值
                // var key_a = sessionStorage.getItem('key_a');
                // console.log(key_a);

            })

            function uploadImg(pick, index, action = 'create') {
                console.log(1);
                $(function () {
                    var uploader = WebUploader.create({
                        // 选完文件后，是否自动上传。
                        auto: true,
                        swf: '{{url(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/Uploader.swf')}}',
                        server: '{{route('upload.image',['_token'=>csrf_token()])}}',
                        pick: pick,
                        fileVal: 'upload_image',
                        accept: {
                            title: 'Images',
                            extensions: 'gif,jpg,jpeg,bmp,png',
                            mimeTypes: 'image/*'
                        }
                    });
                    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
                    uploader.on('uploadSuccess', function (file, response) {
                        console.log(pick);
                        addImg(pick, response.url);
                        $(pick).find('.img-upload').removeClass('img-upload-init')
                    });
                });
            }

            function addImg(pick, url,action = 'create') {

                console.log(pick);

                var img = [" <img width=\"88\" height=\"88\" src=\"" + url +
                "\" alt=\"\">",
                    "                                     <div class=\"replace_img\">",
                    "                                         <span >更换图片</span>",
                    "                                     </div>"].join("");
                $(pick).find('.img-upload').html(img);

                if (action == 'edit') {
                    $(pick).find('.img-upload').addClass('img-upload-end');
                }

                $(pick).find('i').remove();
            }


            function upload(pick) {
                var uploader = WebUploader.create({
                    // 选完文件后，是否自动上传。
                    auto: true,
                    swf: '{{url(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/Uploader.swf')}}',
                    server: '{{route('upload.image',['_token'=>csrf_token()])}}',
                    pick: pick,
                    fileVal: 'upload_image',
                    accept: {
                        title: 'Images',
                        extensions: 'gif,jpg,jpeg,bmp,png',
                        mimeTypes: 'image/*'
                    }
                });
            }

            //删除
            $("body .advert").on("click", ".del", function () {
                var remove = $(this).parents('.advert_li');
                remove.remove();
            });

            $("body .advert").on("click", ".link-input", function () {

                var link_input_input = $(this).find('input');

                var index=link_input_input.data('index');

                var type_s=$($('.advert_li_'+index)).find('.box_input_group').find('.box_input').eq(0).find('.type-s option:selected');

                var index = link_input_input.data('index');

                var val = link_input_input.val();

                //选择商品
                if (type_s.val() == 'store_detail') {

                    var url = "{{route('admin.setting.micro.page.compoent.model.goods')}}"

                    var new_url = url + '?index=' + index + '&goods_id=' + val+'&type='+'micro_page_componet_goods_group_img';

                    $('#promote-goods-btn').data('url', new_url)

                    $("#promote-goods-btn").trigger("click");

                }

                //选择分类
                if (type_s.val() == 'store_list') {

                    var url = "{{route('admin.setting.micro.page.compoent.model.categorys')}}"

                    var new_url = url + '?index=' + index + '&category_id=' + val+'&type='+'micro_page_componet_goods_group_img';

                    $('#promote-goods-btn').data('url', new_url)

                    $("#promote-goods-btn").trigger("click");

                }

                //选择微页面
                if (type_s.val() == 'other_micro') {

                    var url = "{{route('admin.setting.micro.page.compoent.model.pages')}}"

                    var new_url = url + '?index=' + index + '&page_id=' + val+'&type='+'micro_page_componet_goods_group_img';

                    $('#promote-goods-btn').data('url', new_url)

                    $("#promote-goods-btn").trigger("click");

                }


            });

            //选择链接类型
            $("body .advert").on("change", ".type-s", function () {
                var that = $(this);
                var val = that.find("option:selected").val();
                var page = that.find("option:selected").data('page');
                var link_input = that.parents('.advert_li').find('.box_input_group .link-input');
                var link_input_input = $($(link_input)).find('input');
                link_input_input.attr('data-type', val);
                link_input_input.attr('data-page', page);

                if (val == 'other_links') {
                    link_input.show();
                    link_input_input.val('');
                    link_input_input.removeAttr("disabled");
                    link_input_input.attr('placeholder', '请输入微信公众号文章链接');
                } else {
                    link_input.hide();
                    link_input_input.val('');
                    link_input_input.attr("disabled");
                    link_input_input.attr('placeholder', '');
                }

                if (val == 'other') {
                    link_input.show();
                    link_input_input.val('');
                    link_input_input.removeAttr("disabled");
                    link_input_input.attr('placeholder', '请输入自定义链接');
                }

                var index = link_input_input.data('index');

                // 选择商品
                if (val == 'store_detail') {

                    var url = "{{route('admin.setting.micro.page.compoent.model.goods')}}"

                    var new_url = url + '?index=' + index+'&type='+'micro_page_componet_goods_group_img';

                    $('#promote-goods-btn').data('url', new_url)

                    $("#promote-goods-btn").trigger("click");
                }

                // 选择分类
                if(val == 'store_list'){

                    var url = "{{route('admin.setting.micro.page.compoent.model.categorys')}}"

                    var new_url = url + '?index=' + index+'&type='+'micro_page_componet_goods_group_img';

                    $('#promote-goods-btn').data('url', new_url)

                    $("#promote-goods-btn").trigger("click");
                }

                //选择微页面
                if(val == 'other_micro'){

                    var url = "{{route('admin.setting.micro.page.compoent.model.pages')}}"

                    var new_url = url + '?index=' + index+'&type='+'micro_page_componet_goods_group_img';

                    $('#promote-goods-btn').data('url', new_url)

                    $("#promote-goods-btn").trigger("click");
                }

            });


            //检查数据
            function testData() {
                var num = $('.advert_li').length;

            }

            //添加
            function add(id, str) {
                var div = $('#' + id);
                var li = div.append(str);
                console.log(li);
                var num = $('.advert_li').length;
                var ad = $('.advert_li').eq(num - 1).attr('index', num);
                $('.advert_li').eq(num - 1).addClass('advert_li_' + num,);
                $('.advert_li').eq(num - 1).find('.box_img').addClass('upload-' + num);
                $('.advert_li').eq(num - 1).find('.inputLink').addClass('inputLink-' + num);
                $('.advert_li').eq(num - 1).find('.inputLink').data('index', num);
                uploadImg('.upload-' + num, num);
            }

            //保存
            function saveImg(){
                var group_name = $('#group_name').val();

                var index = $('#index').val();
                if (!group_name) {
                    swal("保存失败!", '分组名称不能为空', "error");return;
                }

                var data={};

                $('.advert_li_').each(function (v, obj) {

                    data[v]={'image':null,'type':null,'link':null, 'sort':null,}

                    var obj=$(obj);
                    console.log(obj);

                    var img=obj.find('img').attr('src');
                    if(typeof(img)=='undefined'){
                        swal("保存失败!", '请上传图片', "error");return;
                    }
                    data[v]['image']=img;

                    var type=obj.find('.inputLink').attr('data-type');

                    var page=obj.find('.inputLink').attr('data-page');

                    var name=obj.find('.inputName').val();

                    if(type=='' || page==''){
                        console.log(333);
                        swal("保存失败!", '选择链接类型', "error");return;
                    }
                    var val=obj.find('.inputLink').val();

                    data[v]['type']=type;

                    data[v]['link']=page+val;

                    data[v]['sort']=v+1;

                    data[v]['name']=name

                    switch(type)
                    {
                        case 'store_detail':
                            data[v]['associate_id']=val;
                            data[v]['associate_type']='goods';
                            break;
                        case 'store_list':
                            data[v]['associate_id']=val;
                            data[v]['associate_type']='category';
                            break;
                        case 'other_micro':
                            data[v]['associate_id']=val;
                            data[v]['associate_type']='microPage';
                            break;
                        case 'other_links':
                            data[v]['meta']=JSON.stringify({"link":val});
                            break;
                        case 'other':
                            data[v]['link']=val;
                            break;
                        default:

                    }

                    if(val==''){
                        if(type=='store_detail' || type=='store_list' ||type=='other_links' ||type=='other_micro' || type=='other')
                            swal("保存失败!", '请完善数据', "error");return;
                    }

                })


                var input={};

                input.input=data;

                console.log(input);

                if(JSON.stringify(data) == "{}"){

                    swal("保存失败!", '请先添加', "error");return;
                }

                if(!check_input(input.input)) return;

                compoent_componet_html = compoent_2_html.replace('{#num#}',getLength(input.input));

                compoent_componet_html = compoent_componet_html.replace('{#title#}', group_name);

                compoent_componet_html = compoent_componet_html.replace('{#name#}', group_name);

                compoent_componet_html = compoent_componet_html.replace('{#input#}',JSON.stringify(input.input));

                compoent_componet_html = compoent_componet_html.replace('{#data#}',JSON.stringify(input.input));

                compoent_componet_html = compoent_componet_html.replace('{#len#}',getLength(input.input));

                compoent_componet_html = compoent_componet_html.replace('{#type#}','micro_page_componet_goods_group_img');

                console.log(index);

                if(index>0){
                    compoent_componet_html = compoent_componet_html.replace('{#index#}', index);
                    var obj=$('#bar .advert_li_'+index);
                    obj.after(compoent_componet_html);
                    obj.remove()
                }else{
                    compoent_componet_html = compoent_componet_html.replace('{#index#}', 0);
                    $('#bar').append(compoent_componet_html);
                }
                index_init();

                $('#img_modal').modal('hide');




            }


            function getLength(obj){

                var count = 0;
                for(var i in obj){
                    count++;
                }
                return count;
            }

            function check_input(input) {
                for(k in input){
                    if(!input[k]['image']){
                        return false;
                    }
                    if(!input[k]['type']){
                        return false;
                    }
                    if(!input[k]['link']){
                        return false;
                    }
                }
                return true;
            }

        </script>
        <script>
            (function () {
                'use strict';

                var byId = function (id) {
                        return document.getElementById(id);
                    },

                    loadScripts = function (desc, callback) {
                        var deps = [], key, idx = 0;

                        for (key in desc) {
                            deps.push(key);
                        }

                        (function _next() {
                            var pid,
                                name = deps[idx],
                                script = document.createElement('script');

                            script.type = 'text/javascript';
                            script.src = desc[deps[idx]];

                            pid = setInterval(function () {
                                if (window[name]) {
                                    clearTimeout(pid);

                                    deps[idx++] = window[name];

                                    if (deps[idx]) {
                                        _next();
                                    } else {
                                        callback.apply(null, deps);
                                    }
                                }
                            }, 30);

                            document.getElementsByTagName('head')[0].appendChild(script);
                        })()
                    },

                    console = window.console;

                if (!console.log) {
                    console.log = function () {
                        alert([].join.apply(arguments, ' '));
                    };
                }

                Sortable.create(byId('bar-img'), {
                    group: "words",
                    animation: 150,
                    onAdd: function (evt) {
                        console.log('onAdd.bar:', evt.item);
                    },
                    onUpdate: function (evt) {
                        console.log('onUpdate.bar:', evt.item);
                    },
                    onRemove: function (evt) {
                        console.log('onRemove.bar:', evt.item);
                    },
                    onStart: function (evt) {
                        $('body .module-box-son').addClass('box-select-hide');
                        console.log('onStart.foo:', evt.item);
                    },
                    onEnd: function (evt) {
                        $('body .module-box-son').addClass('box-select-hide');
                        console.log('onEnd.foo:', evt.item);
                        index_init();
                    }
                });

            })();


        </script>
    
@endsection










