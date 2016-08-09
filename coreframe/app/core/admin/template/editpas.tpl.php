<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body id="body" style="overflow-y :scroll;overflow-x:auto;background:#fff;">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="panel" style="box-shadow: none;">
    <div class="panel-body" id="panel-bodys">
        <form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=core&f=index&v=editpas<?php echo $this->su();?>">

            <table class="table table-striped table-advance table-hover">
                <tbody>
                <tr>
                    <td class="text-right"><label class="control-label">用户名</label></td>
                    <td><div class="col-sm-8 col-xs-8"><input class="form-control" id="username" type="text" placeholder="<?php echo $member['username']?>" ></div></td>
                </tr>
                <tr>
                    <td class="text-right"><label class="control-label">密码</label></td>
                    <td><div class="col-sm-8 col-xs-8"><input type="password" name="info[password]" id="password" class="form-control" /></div></td>
                </tr>
                <tr>
                    <td class="text-right"><label class="control-label">确认密码</label></td>
                    <td><div class="col-sm-8 col-xs-8"><input type="password" name="info[pwdconfirm]" class="form-control" recheck="password" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" /></div></td>
                </tr>

                <tr>
                    <td class="text-right"><label class="control-label"></label></td>
                    <td><div class="col-sm-8 col-xs-8 panel-footer">
                            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交"></div>
                    </td>
                </tr>
                </tbody>
            </table>

    </div>
    </form>
    </div>
</section>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3,
            callback:function(form){
                $("#submit").click();
            }

        });
        $("#body").niceScroll({styler:"fb",horizrailenabled:false,cursorcolor:"#c4c8d2",cursorwidth: '6', cursorborderradius: '10px', background: '#E2E7E8', cursorborder: ''});

    });
</script>