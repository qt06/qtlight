<?php
ob_start();
define('qtlight_adm',1);
include('../config.inc.php');

$GLOBALS['config'] = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'config');
$cookie_admin = isset($_COOKIE['admin']) ?$_COOKIE['admin'] : "";
if($cookie_admin != 'admin') {
if(isset($_POST['username'])) {
if($_POST['username'] == $GLOBALS['config']['author'] && md5($_POST['pass']) == $GLOBALS['config']['pass'])
setcookie("admin","admin",time()+3600*24*30,'/',$_SERVER['HTTP_HOST']);
else {
header('Content-Type: text/html; charset=UTF-8');
exit('<html><head><title>QTLIGHT后台登陆</title></head><body><form action="index.php" method="post"><p><label for="username">用户名：</label><input type="text" id="username" name="username" /></p><p><label for="pass">密 码：</label><input type="password" id="pass" name="pass" /></p><p><input type="hidden" name="post_type" value="login" /><input type="submit" value="登陆" /></p></form></body></html>');
}
}
else {
header('Content-Type: text/html; charset=UTF-8');
exit('<html><head><title>QTLIGHT后台登陆</title></head><body><form action="index.php" method="post"><p><label for="username">用户名：</label><input type="text" id="username" name="username" /></p><p><label for="pass">密 码：</label><input type="password" id="pass" name="pass" /></p><p><input type="hidden" name="post_type" value="login" /><input type="submit" value="登陆" /></p></form></body></html>');
}
}

include('adm.php');
if(isset($_GET['type'])) {
include('header.php');
switch($_GET['type']) {
case 'post':
if(isset($_GET['id'])) {
extract(get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_' . $_GET['id']));
$time = date("Y-m-d H:i:s",$createat);
$tags = implode(',',$tags);
$edit = 'edit';
$id = $_GET['id'];
}
else {
$title = '';
$content = '';
$tags = '';
$slug = '';
$time = date("Y-m-d H:i:s",time());
$edit = '';
$id = '';
}
include('post_form.php');
break;
case 'config':
extract($GLOBALS['config']);
include('config_form.php');
break;
case 'set_navbar':
$navbarcode = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'navbarcode');
include('navbar_form.php');
break;
case 'friendlink':
$friendlinkcode = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'friendlinkcode');
include('friendlink_form.php');
break;
case 'pass':
include('pass_form.php');
break;
case 'page':
posts($_GET['id']);
break;
case 'pdel':
del_post();
break;
case 'quit':
setcookie("admin","",time()-3600,'/',$_SERVER['HTTP_HOST']);
exit(header("Location: {$_SERVER['PHP_SELF']}"));
break;
default:
echo "no";
}
include('footer.php');
}
else {
include('header.php');
posts();
include('footer.php');
}


function posts($page = 1) {

$post_list = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list');

if(!empty($post_list))
$post_list = array_reverse($post_list);
$count = count($post_list);
$items = 5;

$begin = $items*$page - $items;
$end = $items*$page;
if($end > $count)
$end = $count;
$post_list = array_slice($post_list,$begin,$items);
echo '<ul>';
foreach($post_list as $k=>$v) {
echo '<li>';
echo '<a href="' . $GLOBALS['config']['siteurl'] . '/admin/?type=post&amp;id=' . $v['id'] . '" title="编辑">' . $v['title'] . '</a> | ';
echo '<a href="' . $GLOBALS['config']['siteurl'] . '/admin/?type=post&amp;id=' . $v['id'] . '" title="编辑">编辑</a> | ';
echo '<a href="' . $GLOBALS['config']['siteurl'] . '/admin/?type=pdel&amp;id=' . $v['id'] . '" title="删除">删除</a> | ';
echo '<a href="' . $GLOBALS['config']['siteurl'] . '/index.php/' . $GLOBALS['config']['post_pre'] . '/' . $v['id'] . $GLOBALS['config']['post_ex'] . '" target="_blank">查看</a>';
echo '</li>';
}
echo '</ul>';
if($count%$items!=0)
$pcount = ceil($count/$items);
else $pcount = $count/$items;
$npage = $page + 1;
if($npage > $pcount)
$npage = $pcount;
$ppage = $page -1;
if($ppage == 0)
$ppage = 1;
echo '<ul class="pagenav">';
if($ppage !=1)
echo '<li><a href="' . $GLOBALS['config']['siteurl'] . '/admin/?type=page&id=' . ($page-1) . '">上一页</a></li>';
echo '<li>' . $page . '</li>';
for($i=1;$i<=$pcount;$i++) {
echo '<li><a href="' .$GLOBALS['config']['siteurl'] . '/admin/?type=page&id=' . $i . '">' . $i . '</a></li>';
}
if($npage < $pcount)
echo '<li><a href="' . $GLOBALS['config']['siteurl'] . '/admin/?type=page&id=' . $npage . '">下一页</a></li>';
echo '</ul>';
}


function del_post() {
$id = isset($_GET['id']) ? $_GET['id'] : '';
if($id != '') {
$pl = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list');
$tags = $pl['post_'.$id]['tags'];
if(!empty($tags)) {
foreach($tags as $v) {
$tl = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'.$v);
unset($tl['post_'.$id]);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'.$v,$tl);
}
}
unset($pl['post_'.$id]);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list',$pl);
del_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_' . $id);
create_cache();
echo '文章删除成功。';
}
else echo '文章不存在，删除失败。';
}
?>