$(document).ready(function(){
    get_area_by_province_id();
    //根据省份ID获取地区List 
    function get_area_by_province_id() {
        $('#province_id').change(function(){
            var str_id = $(this).val();
            $.get('services/goldroll.php',{action:'get', id:str_id},function(data){
                $('#area_id').html(data);
            })
        });
    }
   
    //导入联系人
    import_contact_info ();
    function import_contact_info () {
        $('#contact_info').dialog({
        title: '从历史联系人中导入',
        autoOpen: false,
        resizable: false,
        height: 345,
        width: 375,
        modal: true,
        open:function() {
            jQuery.post('services/select_contact.php', function(data) {  
                jQuery("#contact_info").html(data);  
                contactDialogPage();
            });  
        },
        buttons: {
            '确定': function() {
                var p_id = $('#inbound input[name="contact"]:checked').val();
                jQuery.getJSON('services/insert_contact.php', {id:p_id}, function(data) {
                    $("input[name=import_contact_id]").eq(0).val(data.id);
                    $("input[name=contact_id]").eq(0).val(data.id);
                    $('#p_name').eq(0).val(data.name);
                    $('#p_tel').eq(0).val(data.tel);
                    $('#p_qq').eq(0).val(data.qq);
                    $('#p_mobile').eq(0).val(data.mobile);
                    $('#p_email').eq(0).val(data.email);
                    $('#other_name').eq(0).val(data.other_name);
                    $('#other_tel').eq(0).val(data.other_tel);
                    $('#p_name').eq(0).removeClass('Validform_error');
                    $('#p_tel').eq(0).removeClass('Validform_error');
                    if(data.name!=''){
                        $(".mess_p_name").html('');
                        $(".mess_p_name").hide();
                    }
                    if(data.tel!=''){
                        $(".mess_p_tel").html('');
                        $(".mess_p_tel").hide();
                    }
                    });  
                $( this ).dialog( "close" );
                },
                '取消': function() {
                    $( this ).dialog( "close" );
                }
        }
    });
        $('#contact_import').click(function(){        
            $("#contact_info" ).dialog("open");    
            return false;
        });
    }

    function contactDialogPage() {
        $('#inbound a[class="pagelist"]').click(function(){
            var url = $(this).attr('href');
            $.get(url, function(data) {  
                $("#contact_info").html(data);  
                contactDialogPage();
            }); 
            return false;
        });
     }

     import_business_info();
     // 导入商家
     function import_business_info() {
        $('#local_business #province_id').change(function(){
        var str_id = $(this).val();
        $.get('services/goldroll.php',{action:'get', id:str_id},function(data){
            $('#area_id').html(data);
            })
        });
        $('#dialog').dialog({
        title: '从历史商家名称中选择',
        autoOpen: false,
        resizable: false,
        height: 330,
        width: 375,
        modal: true,
        open:function() {
        jQuery.post('services/select_business.php', function(data) {  
            jQuery("#dialog").html(data); 
            dialogPage();
            });  
        },
        buttons: {
            '确定': function() {
                var b_id = $('#dialog input[name="business"]:checked').val();
                jQuery.getJSON('services/insert_business.php', {id:b_id}, function(data) { 
                    $("input[name=import_business_id]").eq(0).val(data.id);
                    $('#b_name').eq(0).val(data.name);
                    $('#b_tel').eq(0).val(data.tel);
                    $('#b_year').eq(0).val(data.number_years);
                    $('#b_seat').eq(0).val(data.seats);
                    $('#b_fund').eq(0).val(data.funds);
                    $('#b_area').eq(0).val(data.business_area);
                    //$('#province_id')[0].selectedIndex = 1;
                    //$('#area_id')[0].selectedIndex = 1;
                    //$('#b_address').eq(0).val(data.desc);
                    $('#b_name').eq(0).removeClass('Validform_error');
                    $('#b_tel').eq(0).removeClass('Validform_error');
                    if(data.name!=''){
                        $(".mess_b_name").html('');
                        $(".mess_b_name").hide();
                    }
                    });  
            $(this).dialog( "close" );
            },
            '取消': function() {
                $( this ).dialog( "close" );
            }
        }
        });
        $('#import').click(function(){
            $("#dialog" ).dialog("open");    
            return false;
        });
    }

    function dialogPage() {
        $('#inbound a[class="pagelist"]').click(function(){
            var url = $(this).attr('href');
            $.get(url, function(data) {  
                $("#dialog").html(data);  
                dialogPage();
            }); 
            return false;
        });
    }

    get_cityname_data();
    function get_cityname_data(){
        $('#city_log').dialog({
        title: '请您选择包邮的城市',
        autoOpen: false,
        resizable: false,
        height: 400,
        width: 375,
        modal: true,
        open:function() {
        
        jQuery.post('services/get_cityname_data.php',function(data) {  
            jQuery("#city_log").html(data);  
            get_province_area();
            });  
        },
         buttons: {
        '确定': function() {
             $( this ).dialog( "close" );
        },
        '拒绝': function() {
             $( this ).dialog( "close" );
        }
        }
        });
         $('#city_mess').click(function(){
                $("#releasenetsother #city_list").show();
                $("#city_log" ).dialog("open");    
                return false;
        });
    
    }
   
    //处理选择的城市和根据省份ID获取地区
    function get_province_area(){
        $("#city_log .area").click(function(){              
            var key = $(this).attr('key');
            var value = $(this).attr('value');
            var str_id = '';
            str_id += key+',';
            var area_id = $("input[name='mailing_city']").val();
            $("input[name='mailing_city']").val(area_id+str_id);
            var html = $("#cityname #city_list .city_list").html();
            var input_data = "<a id="+key+">"+value+"</a>";
            var js = html.indexOf(value);
            js=parseInt(js);
            if(js==-1){
                $('#city_list .city_list').append(input_data);
            } 
            return false;    
        });
        $('#city_log .province').click(function(){
            $(".area_type").hide();
            var key = $(this).attr('key');
            //直辖市的处理
            if(key==11 || key==31 || key==81 || key==82 || key==12 || key==50){
                //根据省份ID去请求地区ID
                var value = $(this).attr('value');
                $.get('services/get_cityname_data.php', {action:'areaname', id:key}, function(data) {
                    var str_id = '';
                    str_id += data+',';
                    var area_id = $("input[name='mailing_city']").val();
                    $("input[name='mailing_city']").val(area_id+str_id);
                    var html = $("#cityname #city_list .city_list").html();
                    var input_data = "<a id="+data+">"+value+"</a>";
                    var js = html.indexOf(value);
                    js=parseInt(js);
                    if(js==-1){
                        $('#city_list .city_list').append(input_data);
                    } 
                    return false;
                });
            } else {
                //其它省份的处理
                $.get('services/get_cityname_data.php', {action:'cityname', id:key}, function(data) {
                    $('div[id="'+key+'"]').show();
                    $('div[id="'+key+'"]').append(data);
                    item_area();
                    return false;
                });  
            }
            return false;
         });
    }

    function item_area(){
            $("#city_log .area_type .item_area").click(function(){
                    //把邮寄的地区写入到input
                    var key = $(this).attr('key');
                    var value = $(this).attr('value');
                    var str_id = '';
                    str_id += key+',';
                    var area_id = $("input[name='mailing_city']").val();
                    $("input[name='mailing_city']").val(area_id+str_id);
                    var html = $("#cityname #city_list .city_list").html();
                    var input_data = "<a id="+key+">"+value+"</a>";
                    var js = html.indexOf(value);
                    js=parseInt(js);
                    if(js==-1){
                        $('#city_list .city_list').append(input_data);
                    } 
                    return false;

                $('.area_type').mouseout(function(){
                        $(this).hide();
                });
            });
    }
    yanzheng_int();
    //验证整性
    function yanzheng_int(){
        $("#market_price").blur(function(){      
                var market_price = $(this).val();
                if(isNaN(market_price)){
                    $(this).val("");
                    $(".mess_market_price").html("你输入的市场价必须是数字类型");
                    $(".mess_market_price").show();
                } else if(market_price == ''){
                    $(".mess_market_price").html("市场价不能为空"); 
                    $(".mess_market_price").show();
                }  else {
                    $(".mess_market_price").hide();
            }
        });

        $("#supply_price").blur(function(){      
                var supply_price = $(this).val();
                var market_price = $(".mess_market_price");
                if(supply_price.length>5){
                    $(this).val("");
                    market_price.html("你输入的建议团购价不能多于5个汉字字符");
                    market_price.show(); 
                } else if(supply_price == ''){
                    market_price.html("建议团购价不能为空"); 
                    market_price.show(); 
                } else {
                    market_price.html(''); 
                    market_price.hide(); 
                }
        });
        $("#foreign_price").blur(function(){      
                var foreign_price = $(this).val();
                if(isNaN(foreign_price)){
                    $(this).val("");
                    $(".mess_foreign_price").html("你输入的供货价必须是数字类型");
                    $(".mess_foreign_price").show(); 
                } else if(foreign_price == ''){
                   $(".mess_foreign_price").html("供货价不能为空"); 
                    $(".mess_foreign_price").show(); 
                } else {
                    $(".mess_foreign_price").html('');
                    $(".mess_foreign_price").hide(); 
                }
        });

        $('input[name=title]').blur(function(){
            var title = $(this).val();
            if(title.length == 0) {
                $(".mess_title").html('标题不能为空');
                $(".mess_title").show();
            } else {
                $(".mess_title").html('');
                $(".mess_title").hide();
            }
        });

        $('#content').click(function(){
            var content = $(this).val();
            if(content.length == 0) {
                $(".mess_content").html('商品描述不能为空');
            } else {
                $(".mess_content").html('');
                $(".mess_content").hide();
            }
        });

        $('input[name=b_name]').blur(function(){
            var b_name = $(this).val();
            var mess_bname = $(".mess_b_name");
            if(b_name.length == 0) {
                mess_bname.html('商家名称不能为空');
                mess_bname.show();
            } else {
                mess_bname.html('');
                mess_bname.hide();
            }
        });

        $('#p_name').blur(function(){
            var p_name = $(this).val();
            var mess_name = $(".mess_p_name");
            if(p_name.length == 0) {
                mess_name.html("<font style='color:red;'>联系人姓名必须填写</font>");
                mess_name.show();
            } else {
                mess_name.html('');
                mess_name.hide();
            }
        });

         $('#p_tel').blur(function(){
            var p_tel = $(this).val();
            var mess_tel = $(".mess_p_tel");
            if(p_tel.length == 0) {
                mess_tel.html("<font style='color:red;'>联系人电话不能为空</font>");
                mess_tel.show();
            } else {
                mess_tel.html('');
                mess_tel.hide();
            }
        });

        $('#province_id').click(function(){
            var province_id = $(this).val();
            var mess_address= $(".mess_address");
            if(province_id==0 || province_id=='') {
                mess_address.html("<p style='color:red;'>商家所在省份不能空</p>");
                mess_address.show();
            } else {
                mess_address.html('');
                mess_address.hide();
            }
        });

        $('#area_id').click(function(){
            var area_id = $(this).val();
            if(area_id==0 || area_id=='') {
                $(".mess_address").html("<p style='color:red;'>商家所在城市不能空</p>");
                $(".mess_address").show();
            } else {
                $(".mess_address").html('');
                $(".mess_address").hide();
            }
        });

        $('#b_address').blur(function(){
            var b_address = $(this).val();
            if(b_address=='') {
                $(".mess_address").html("<p style='color:red;'>商家详细地址不能空</p>");
                $(".mess_address").show();
            } else {
                $(".mess_address").html('');
                $(".mess_address").hide();
            }
        });
    }

    //锚点处理
    function to_location(a) {
            var url = location.href;
            var t = '';
            if(url.indexOf('#')>0) {
                url   = url.substring(0, url.lastIndexOf('#'));
            } 
            t   = url + '#' + a;
            location.href = t; 
            return false;
    }   

    postSubmit();
    function postSubmit(){
    $('#submit .submit').click(function(){
                var w_type = $("input[name=w_type]").val();
                var title = $('input[name=title]').val();
                if(title.length==0) {
                    $(".mess_title").html('标题不能为空');
                    to_location('pro_name');
                    return false;
                }
                var market_price = $('#market_price').val();
                if(market_price.length==0) {
                    $(".mess_market_price").html('市场价格必须填写');
                    to_location('product_mprice');
                    return false;
                } 

                var supply_price = $('#supply_price').val();
                if(supply_price.length==0) {
                    $(".mess_market_price").html('供货价格必须填写');
                    to_location('product_sprice');
                    return false;
                }

                if(w_type=='net') {
                    var foreign_price = $("#foreign_price").val();
                    if(foreign_price.length==0){
                        $(".mess_foreign_price").html("对外销售价不能为空");
                        to_location('product_fprice');
                        return false;
                    }
                }

                var content = $("#content").val();
                if(content.length == 0) {
                    $(".mess_content").html('商品描述不能为空');
                    to_location('product_desc');
                    return false;
                } else {
                    $(".mess_content").html('');
                }
                var b_name = $("input[name=b_name]").val();
                if(b_name.length==0){
                    $(".mess_b_name").html('商家名称必须填写');
                    to_location('product_bname');
                    return false;
                }
                var p_name = $("input[name=p_name]").val();
                if(p_name.length==0){
                    $(".mess_p_name").html("<font style='color:red;'>联系人姓名必须填写</font>");
                    to_location('product_cname');
                    return false;
                }
                var p_tel = $("input[name=p_tel]").val(); 
                if(p_tel.length == 0) {
                    $(".mess_p_tel").html("<font style='color:red'>联系人电话不能为空</font>");
                    to_location('product_ctel');
                    return false;
                }
                var p_email = $("input[name=p_email]").val();
                if(p_email.length>0){
                    var reg="/^[url]http://([/url][\w-]+\.)+[\w-]+(/[\w-./?%&=])?/";
                    if(!reg.test(url)){
                        $(".mess_p_email").html('联系人Email格式有误');
                        to_location('product_email');
                        return false;
                    }
                }
                var province_id = $("#province_id").val();
                if(province_id==0) {
                    $(".mess_address").html("<p style='color:red;'>商家所在省份不能空</p>");
                    to_location('product_province');
                    return false;
                }
                var area_id = $("#area_id").val();
                if(area_id==0) {
                    $(".mess_address").html("<p style='color:red;'>商家所在城市不能空</p>");
                    to_location('product_area');
                    return false;
                }
                var b_address = $("#b_address").val();
                if(b_address=='') {
                    $(".mess_address").html("<p style='color:red;'>商家详细地址不能空</p>");
                    to_location('product_address');
                    return false;
                }
                return true;
            });
    }
    
    //精品网货的表单处理
    releasenets_other();
    function releasenets_other(){
        $("#releasenetsother .part").click(function(){  
            $("#releasenetsother #cityname").show();
        });
        $("#releasenetsother .mailing").click(function(){
            $("#releasenetsother #cityname").hide();
        });
        $("#releasenetsother .way2").click(function(){   
            $("#releasenetsother #express").show();       
        });
        $("#releasenetsother .way1").click(function(){   
            $("#releasenetsother #express").hide();       
        });
    }

    //是否连锁店的处理
    chain_store();
    function chain_store() {
        $("input[name='chain_store'][value='1']").click(function(){
            $('#local_other .chain').show();
            $("input[name='chain_store'][value='0']").bind('click', function() {
                $('#local_other .chain').hide();
            });
        });
    }

    validate_request();
    function validate_request() {
        $(".request").each(function(i){
            $(this).bind({
                focusout:function() {
                    var value = $(this).val();
                    if(value.length==0) {
                        $(this).addClass('Validform_error');
                    } 
                },
                focusin:function(){
                    $(this).removeClass('Validform_error');
                }
                });
        });
    }

    //有效期时间处理
    inputdate();
    function  inputdate(){
        $("#submit #inputdate").blur(function(){
            var value = $(this).val();
            if(value!=''){
                $("input[name=expired]").attr('checked',false); 
            }
            $("#submit #qita").attr('checked',true);   
        });

        $("#submit .radio").click(function(){
                $("#submit #inputdate").val('');
        });
    }
    function goldroll_pric(){
        $("input[name=price_y]").blur(function(){
                var price_x = $("input[name=price_x]").val();
                var price_y = $(this).val(); 
                if(price_x == "") { return false; }
                if(price_y == "") { return false; }
                $("#goldroll .price").val("满"+price_x+"返回"+price_y);
        });
    }
    function goldroll_url(){
        $("input[name=w_url]").blur(function(){
            var w_url = $(this).val();
            var reg="/^[url]http://([/url][\w-]+\.)+[\w-]+(/[\w-./?%&=])?/";
            if(w_url == ""){ return false; }
            if(!reg.test(w_url)){
            $("#goldroll .mess_url").html('url格式不正确');
            }
        });
    }
    //goldroll_url();
    //goldroll_price(); 
});
