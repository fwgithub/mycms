<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 网站后台首页
 * 每小时内密码错误次数达到5次，锁定登录。
 * 记录用户登录的历史记录
 * 记录用户登录的错误记录
 */
load_class('admin');

final class index extends WUZHI_admin {
    function __construct() {
        $this->db = load_class('db');
    }
    function init() {
        $lang = get_cookie('lang') ? get_cookie('lang') : LANG;
        require COREFRAME_ROOT.'languages/'.$lang.'/admin_menu.lang.php';
        $_panels = $panels = array();
        $result = $this->db->get_list('menu', 'pid<20 AND display=1', '*', 0, 6000, 0, 'sort ASC', '', 'menuid');
        //限制非超管用户的访问菜单
        if ($_SESSION['role']!=1) {
            $admin_private = $this->db->get_list('admin_private', 'chk=1 AND role='.$_SESSION['role'],'*', 0, 1000, 0, '', '', 'id');
            $admin_private_keys = array_keys($admin_private);
        }

        foreach($result as $key=>$r) {
            if($_SESSION['role']!=1 && !in_array($key,$admin_private_keys)) continue;
            if($key<20) {
                $panels[$key] = $r;
            } else {
                $_panels[$r['pid']][$key] = $r;
            }
        }
        //       $username = get_cookie('username');
        $username = get_cookie('username');
        $truename = get_cookie('wz_name');
        $ip = $_SESSION['ip'];
        $show_dialog = 1;
        $last_rs = $this->db->get_one('logintime',array('uid'=>$_SESSION['uid'],'status'=>1));
        $sitelist = get_cache('sitelist');
		if(empty($sitelist)) {
			$sitelist = array(1=>array(
				'siteid'=>'1',
				'name'=>'默认站点',
				)
			);
		}
        $siteid = get_cookie('siteid');
        if(!$siteid) {
            $siteid = 1;
            set_cookie('siteid',1);
        }
        print_r($username);
        include $this->template('index');
        //$soap = new SoapClient(null,array('location'=>"http://localhost/Test/MyService/Server.php",'uri'=>'Server.php'));
    }


    function listing() {
        // query db version
        $dbversion = $this->db->version();
        //$total_member
        $total_member = $this->db->count_result('member');
        $regtime = strtotime(date('Y-m-d'));
        $today_member = $this->db->count_result('member',"regtime>$regtime");

        $modellist = get_cache('model_content','model');
        $total_number = $this->db->count_result('content_share',"`status`=9");
        $status_number = $this->db->count_result('content_share',"`status`<4");
        foreach($modellist as $model) {
            $master_table = $model['master_table'];
            if($master_table=='content_share') continue;
            $tmp = $this->db->count_result($master_table,"`status`=9");
            $tmp2 = $this->db->count_result($master_table,"`status`<4");
            $total_number += $tmp;
            $status_number += $tmp2;
        }

        ob_start();
        include $this->template('listing');
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    /**
     * 显示 phpinfo 内容
     */
    function phpinfo() {
        echo phpinfo();
    }


    //登录
    function login() {
        //print_r(123);
        //已经登陆的用户重定向到后台首页
        /*if (isset($_SESSION['uid']) && $_SESSION['uid']!='') {
            MSG(L('already login'), '?m=core&f=index'.$this->su(0));
        }*/

        if(isset($GLOBALS['submit'])) {
            if(!isset($_SESSION['code']) && $_SERVER["SERVER_NAME"]!=parse_url(WEBURL, PHP_URL_HOST)) {
                MSG(L('session error'));
            }
            if(strtolower($GLOBALS['checkcode']) != $_SESSION['code']) {
                $_SESSION['code'] = '';
                MSG(L('checkcode error'),HTTP_REFERER);
            }
            //验证密码是否正确，后台管理员与前台用户相同，管理员密码可独立设置

            $username = isset($GLOBALS['username']) ? p_htmlspecialchars($GLOBALS['username']) : '';
            $password = isset($GLOBALS['password']) ? $GLOBALS['password'] : '';

            $this->check_login($username,$password);

            $_SESSION['uid'] = $_SESSION['role'] = 0;
            MSG(L('username or password error'));
        } else {
            //显示登录界面

            include $this->template('login');
        }
    }

    //注销
    function logout() {

        if(isset($_SESSION['uid'])){
            $_SESSION = array();
        }

        set_cookie('username','');
        set_cookie('wz_name','');

        MSG(L('logout_success'), '?m=core&f=index&v=login'.$this->su(0));
    }

    //锁屏
    function lockscreen() {

        $_SESSION['lock_screen'] = 1;
        $username = get_cookie('username');
        $truename = get_cookie('truename');
        exit('1');

    }

    //解锁屏
    function unlockscreen() {

        $uid = $_SESSION['uid'];
        $password = isset($GLOBALS['password']) ? $GLOBALS['password'] : '';

        if(empty($uid)){
            exit(L('session timeout'));
        }

        if(empty($password)){
            exit(L('password is requierd'));
        }

        $r = $this->db->get_one('member',array('uid'=>$uid));
        if($r['password']) {
            $rs = $this->db->get_one('admin',array('uid'=>$uid));
            if($rs) {
                $login_ok = FALSE;
                //判断是否设置独立密码
                if($rs['password'] && (md5(md5($password).$rs['factor'])==$rs['password'])) {
                    $login_ok = TRUE;
                } elseif(md5(md5($password).$r['factor'])==$r['password']) {
                    $login_ok = TRUE;
                }
                if($login_ok===TRUE) {
                    $_SESSION['lock_screen'] = 0;
                    exit('0');
                } else {
                    //验证失败
                    exit(L('password not match'));
                }
            }else{
                exit(L('user not found'));
            }
        }else{
            exit(L('invalid user'));
        }

    }


    private function check_login($username,$password){


        if(empty($username)) MSG(L('please enter the correct username'));
        if(empty($password)) MSG(L('please enter the correct password'));

        $r = $this->db->get_one('member',array('username'=>$username));
        if($r['password']) {
            $uid = $r['uid'];
            //判断登录次数
            $starttime = SYS_TIME-3600;
            $logintime = $this->db->count_result('logintime',"`uid`='$uid' AND `status`=0 AND `logintime`>'$starttime'");

            if($logintime > 5) {
                MSG(L('login times exceeds limit'));
            }

            $rs = $this->db->get_one('admin',array('uid'=>$uid));
            if($rs) {
                $login_ok = FALSE;
                $ip = get_ip();
                //判断是否设置独立密码
                if($rs['password'] && (md5(md5($password).$rs['factor'])==$rs['password'])) {
                    $login_ok = TRUE;
                } elseif($rs['password']) {
                    $login_ok = FALSE;
                } elseif(md5(md5($password).$r['factor'])==$r['password']) {
                    $login_ok = TRUE;
                }
                if($login_ok===TRUE) {
                    $_SESSION['uid'] = $uid;
                    $_SESSION['role'] = $rs['role'];
                    set_cookie('username',$username);
                    set_cookie('wz_name',$rs['truename']);
                    $_SESSION['ip'] = $ip;
                    $_SESSION['lock_screen'] = 0;

                    //login success!
                    $this->db->insert('logintime',array('uid'=>$uid,'status'=>1,'logintime'=>SYS_TIME,'ip'=>$ip));
                    MSG(L('login success'),'?m=core&f=index'.$this->su(0),500);
                } else {
                    //验证失败
                    $this->db->insert('logintime',array('uid'=>$uid,'status'=>0,'logintime'=>SYS_TIME,'ip'=>$ip));
                }
            }
        }

    }
    public function checknew_version() {
        $a1 = 'w';
        $a2 = 'zhi';
        echo file_get_contents('http://'.$a1.$a1.$a1.'.'.$a1.'u'.$a2.'cms.com/api/checknew_version.php?ver='.VERSION.'&domain='.WEBURL);
    }
    /**
     * 后台左侧菜单
     */
    public function left() {
        $lang = get_cookie('lang') ? get_cookie('lang') : LANG;
        require COREFRAME_ROOT.'languages/'.$lang.'/admin_menu.lang.php';
        $menuid = intval($GLOBALS['id']);
        $result = $this->db->get_list('menu',array('pid'=>$menuid,'display'=>1), '*', 0, 100, 0, 'sort ASC', '', 'menuid');
        include $this->template('left');
    }

    /**
     * 保持登录状态
     */
    public function keep_alive() {
        $uid = $_SESSION['uid'];
        echo date('H:i:s',SYS_TIME);
    }

    public function welcome() {

        echo '<div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>欢迎来到运营数据统计管理后台!</span>
                            <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task">
                        <tbody>

                        <tr>
                            <td><strong>admin</strong>：【职位】<br>
                                <div  class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">您的相关信息</h4>
                                            </div>
                                            <div class="modal-body">
                                               
                                                    <strong>用户名</strong>：admin <br>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                               
                            </td>
 
                        </tr>

                        <tr>
                            <td>
                                <strong>职位</strong>：
                                <span style="color: rgb(244, 83, 107);"></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>真实姓名</strong>：
                                <strong></strong>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>';
    }

    //修改密码
    public function editpas() {
        print_r($_SESSION);
        if(isset($GLOBALS['submit'])) {

            //$this->db->update('admin', array('factor'=>$factor, 'password'=>md5(md5($password).$factor)), '`uid`='.$uid);
        } else {
            include $this->template('editpas');
        }

    }
    //每日充值统计
    public function mrcztj() {
        echo '<header class="panel-heading">
			<form class="form-inline" role="form">
				<input type="hidden" name="m" value="<?php echo M;?>" />
				<input type="hidden" name="f" value="<?php echo F;?>" />
				<input type="hidden" name="v" value="<?php echo V;?>" />
				<input type="hidden" name="_su" value="<?php echo _SU;?>" />
				<input type="hidden" name="_menuid" value="<?php echo $GLOBALS[\'_menuid\'];?>" />
				<input type="hidden" name="search" />
				<div class="input-group">
					<select name="keyType" class="form-control">
						<?php foreach($keyArr as $k=>$v){?>
						<option value="<?php echo $k;?>" <?php echo $keyType == $k ? \'selected\' : \'\'?>><?php echo $v;?></option>
						<?php }?>
					</select>
				</div>
				<input type="text" name="keyValue" class="usernamekey form-control" value="<?php echo $keyValue?>"/>
				<div class="input-group">
					<select name="groupid" class="form-control">
						<option value=\'\' >会员组</option>
						<?php if(is_array($group))foreach($group as $v){?>
						<option value="<?php echo $v[\'groupid\'];?>"<?php echo $v[\'groupid\'] == $groupid ? \'selected\' : \'\'?>><?php echo $v[\'name\'];?></option>
						<?php }?>
					</select>
				</div>
				　　注册时间 <?php echo WUZHI_form::calendar(\'regTimeStart\', $regTimeStart ? date(\'Y-m-d\', $regTimeStart) : \'\');?>- <?php echo WUZHI_form::calendar(\'regTimeEnd\', $regTimeEnd ? date(\'Y-m-d\', $regTimeEnd) : \'\');?>
				　　登录时间 <?php echo WUZHI_form::calendar(\'loginTimeStart\', $loginTimeStart ? date(\'Y-m-d\', $loginTimeStart) : \'\');?>- <?php echo WUZHI_form::calendar(\'loginTimeEnd\', $loginTimeEnd ? date(\'Y-m-d\', $loginTimeEnd) : \'\');?>
				<button type="submit" class="btn btn-info btn-sm">搜索</button>
			</form>
		</header>';

    }
    //查看重置账号操作
    public function ckczzhcz() {
        print_r($_SESSION);
        if(isset($GLOBALS['submit'])) {

            //$this->db->update('admin', array('factor'=>$factor, 'password'=>md5(md5($password).$factor)), '`uid`='.$uid);
        } else {
            include $this->template('editpas');
        }

    }
    //重置账号密码密保
    public function czzhmmmb() {

    }

    //查询账号信息
    public function cxzhxx() {

    }

    //账号操作处理
    public function zhczcl() {

    }

    //用户角色查询
    public function yhjscx() {

    }
    //用户角色操作
    public function yhjscz() {

    }
    //公告管理
    public function gggl() {

    }
    //公告发送
    public function ggfs() {

    }
    // GM权限管理
    public function gmqxgl() {
        if(isset($GLOBALS['submit'])) {

            //$this->db->update('admin', array('factor'=>$factor, 'password'=>md5(md5($password).$factor)), '`uid`='.$uid);
        } else {
            $parent_top = $this->db->get_list('menu', '`pid`=0', '*', 0, 20);
            $result = $this->db->get_list('menu', '', '*', 0, 2000, 0, 'sort ASC');
            $privates_rs = $this->db->get_list('admin_private', array('role'=>1), '*', 0, 2000);
            $privates = array();
            foreach($privates_rs as $rs) {
                if($rs['chk']) $privates[] = $rs['id'];
            }
            include $this->template('gmqxgl');
        }
    }
    //地图服务器设置
    public function dtfwqsz() {

    }
    //地图服务器查询
    public function dtfwqcx() {

    }
    //活动开关
    public function hdkg() {

    }
    //在线GM操作
    public function zxgmczs() {

    }
}
?>