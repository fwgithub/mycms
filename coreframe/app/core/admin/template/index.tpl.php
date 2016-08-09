<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
    <meta name="description" content="" />
    <title>运营数据统计</title>
    <script src="<?php echo R;?>js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo R;?>css/stylee.css" />
    <link href="<?php echo R;?>css/jquery-accordion-menu.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo R;?>js/jquery-accordion-menu.js" type="text/javascript"></script>
</head>
<body>
<div id="main">
    <div class="login_in">
        <div class="wel">
            <i class="rw"></i>
            <span>您好:</span>
            <b><p><?php echo $username;?>【职位】</p></b>
        </div>
        <div class="exit">
            <i class="ext"></i>
            <a href="index.php?m=core&f=index&v=logout<?php echo $this->su();?>">安全退出</a>
        </div>
    </div>
    <div class="main_left">
        <div class="main_logo">
            <img href="<?php echo WEBURL;?>" src="<?php echo R;?>image/logo.jpg" />
        </div>
        <div class="main_meun">
            <div id="jquery-accordion-menu" class="jquery-accordion-menu red">
                <ul id="demo-list">
                    <li><a href="#" class="title"><i class="icon_2"></i>个人设置与统计 </a>
                        <ul class="submenu">
                            <li><a onclick="_PANEL(this,86,'?m=core&f=index&v=editpas')" href="#">> 个人密码修改</a></li>
                            <li class="fen"><a onclick="_PANEL(this,86,'?m=core&f=index&v=mrcztj')" href="#">> 每日充值统计 </a></li>
                            <li><a onclick="_PANEL(this,86,'?m=core&f=index&v=keep_alive')" href="#">> 充值记录查询 </a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="title"><i class="icon_1"></i>运营数据统计</a>
                        <ul class="submenu">
                            <li><a href="#">> 客户端安装卸载统计</a></li>
                            <li class="fen"><a href="#">> 运营数据统计 </a></li>
                            <li><a href="#">> 用户留存率 </a></li>
                            <li class="fen"><a href="#">> 充值超过某值用户</a></li>
                            <li><a href="#">> 流失账号主线统计</a></li>
                            <li class="fen"><a href="#">> 分服留存率统计 </a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="title"><i class="icon_2"></i>广告监控 </a>
                        <ul class="submenu">
                            <li><a href="#">> 媒体列表</a></li>
                            <li class="fen"><a href="#">> 投放广告列表 </a></li>
                            <li><a href="#">> 百度投放 </a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="title"><i class="icon_3"></i>财务查询 </a>
                        <ul class="submenu">
                            <li><a href="#">> 每日支付查询</a></li>
                            <li class="fen"><a href="#">> 每日充值统计 </a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="title"><i class="icon_4"></i>游戏数据统计 </a>
                        <ul class="submenu">
                            <li><a href="#">> 实时在线统计</a></li>
                            <li class="fen"><a href="#">> 历史在线统计 </a></li>
                            <li><a href="#">> 日新增用户数</a></li>
                            <li class="fen"><a href="#">> KPI总报表 </a></li>
                            <li><a href="#">> KPI分服报表</a></li>
                            <li class="fen"><a href="#">> 游戏币统计 </a></li>
                            <li><a href="#">> （各种）活动统计</a></li>
                            <li class="fen"><a href="#">> 角色统计 </a></li>
                            <li><a href="#">> 随身商店售出物品统计</a></li>
                            <li class="fen"><a href="#">> 历史登录账号数 </a></li>
                            <li><a href="#">> 大闹天宫活动统计</a></li>
                            <li class="fen"><a href="#">> 战斗力排行 </a></li>
                            <li><a href="#">> 武圣各服角色提取统计</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="title"><i class="icon_5"></i>GM工具 </a>
                        <ul class="submenu">
                            <li><a onclick="_PANEL(this,86,'?m=core&f=index&v=ckczzhcz')" href="#">> 查看重置账号操作</a></li>
                            <li class="fen"><a href="#">> 重置账号密码密保 </a></li>
                            <li><a href="#">> 查询账号信息</a></li>
                            <li class="fen"><a href="#">> 账号操作处理</a></li>
                            <li><a href="#">> 用户角色查询</a></li>
                            <li class="fen"><a href="#">> 用户角色操作 </a></li>
                            <li><a href="#">> 公告管理</a></li>
                            <li class="fen"><a href="#">> 公告发送 </a></li>
                            <li><a onclick="_PANEL(this,86,'?m=core&f=index&v=gmqxgl')" href="#">> GM权限管理</a></li>
                            <li class="fen"><a href="#">> 地图服务器设置 </a></li>
                            <li><a href="#">> 地图服务器查询</a></li>
                            <li class="fen"><a href="#">> 活动开关 </a></li>
                            <li><a href="#">> 在线GM操作</a></li>

                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="main_right">
        <div class="right_top">
            <div class="list_meun">
                <a href="">系统管理</a>
                <span></span>
                <a href="" class="meun_on">武圣</a>
            </div>
            <div class="list_li">
                <div class="list_txt">
                    <b>您的位置：</b>
                    <a href="">武圣</a>
                    <span></span>
                    <a href="">欢迎页面</a>
                    <span></span>

                </div>
            </div>
        </div>
        <div class="right_cont">
            <div class="right_head">
                <i></i><b>系统信息</b>
            </div>

        </div>
        <section id="iframecontent"><iframe  width="100%" height="100%" name="iframeid" id="iframeid" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="?m=core&f=index&v=welcome<?php echo $this->su();?>"></iframe>
        </section>
    </div>
</div>
<script type="text/javascript">
    function _PANEL(obj,menuid,gotourl) {
        $("#iframeid").attr('src', gotourl+'<?php echo $this->su(0);?>&_menuid='+menuid);
        //$("._p_menu").removeClass('active');
        //$(obj).addClass('active');
        //var mypos = $(obj).html();
        //$("#position").html(parentpos+mypos+"<span>></span>");
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#jquery-accordion-menu").jqueryAccordionMenu();

    });

    $(function(){
        //列表项背景颜色切换
        $("#demo-list li").click(function(){
            $("#demo-list li.active").removeClass("active")
            $(this).addClass("active");
        })
    })
</script>
<script type="text/javascript">
    (function($) {
        $.expr[":"].Contains = function(a, i, m) {
            return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };
        function filterList(header, list) {
            //@header 头部元素
            //@list 无序列表
            //创建一个搜素表单
            var form = $("<form>").attr({
                "class":"filterform",
                action:"#"
            }), input = $("<input>").attr({
                "class":"filterinput",
                type:"text"
            });
            $(form).append(input).appendTo(header);
            $(input).change(function() {
                var filter = $(this).val();
                if (filter) {
                    $matches = $(list).find("a:Contains(" + filter + ")").parent();
                    $("li", list).not($matches).slideUp();
                    $matches.slideDown();
                } else {
                    $(list).find("li").slideDown();
                }
                return false;
            }).keyup(function() {
                $(this).change();
            });
        }
        $(function() {
            filterList($("#form"), $("#demo-list"));
        });
    })(jQuery);
</script>
</body>
</html>
