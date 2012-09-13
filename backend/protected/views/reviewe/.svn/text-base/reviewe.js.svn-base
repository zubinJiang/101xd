$(document).ready(function(){
        $('#reviewe a.recommend').click(function(){
            var this_a = $(this);
            var url_   = this_a.attr('rel');
            var id   = url_.substring(url_.lastIndexOf('=')+1, url_.length);
            var str_text = this_a.text();
            
            $.getJSON(url_, function(data){ 
                if(str_text=='推荐'){
                    this_a.text('取消推荐');
                    this_a.attr('title','此操作将取消推荐');
                    url_ = url_.replace("recommend=0","recommend=1");   
                    this_a.attr('rel', url_);
                    this_a.attr('title','此操作将取消推荐');
                    $('#reviewe .'+id+'_reviewestatus').text('已通过');
                } else {
                    this_a.text('推荐');
                    url_ = url_.replace("recommend=1","recommend=0");   
                    this_a.attr('title','此操作将推荐此产品');
                    this_a.attr('rel', url_);
                }
                return false;
            });
            return false;
        });

        $('#reviewe li a.active').click(function(){
            var url_ = $(this).attr('rel');
            var id   = url_.substring(url_.lastIndexOf('=')+1, url_.length);
            jAlert('确认将要进行操作','确认操作？',function(r){
                if (r){
                    var del = url_.indexOf('delete');
                    if(del>0) {
                        $.getJSON(url_, function(data){
                            $('#reviewe li[id="'+id+'"]').hide();
                        });
                    } else {
                        $.getJSON(url_, function(data){
                            var re_status = '未通过';
                            if(data.auth==0) {
                                if(data.result==1) {
                                    re_status = 'vip供货';
                                } else {
                                    re_status = '审核中';
                                }
                            } else if(data.auth==1) {
                                re_status = '已通过';
                            } else if(data.auth==2) {
                                re_status = '未通过';
                            }

                            $('#reviewe .'+id+'_reviewestatus').text(re_status);
                        });
                    }
                }
                return false;
            });
            return false;
            });

})
