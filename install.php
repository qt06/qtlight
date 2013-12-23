<?php
include('config.inc.php');
if(get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'install_lock'))
exit(header("Location: index.php"));

if(isset($_POST['post_type'])) {
switch($_POST['post_type']) {
case 'config':
$sitename = trim($_POST['sitename']);
$siteurl = trim($_POST['siteurl']);
$sitedesc = trim($_POST['sitedesc']);
$author = trim($_POST['author']);
$pass = md5(trim($_POST['pass']));
$site_keywords = trim($_POST['site_keywords']);
$site_keydesc = trim($_POST['site_keydesc']);
$comment_code = get_magic_quotes_gpc() ? stripslashes(trim($_POST['comment_code'])) : trim($_POST['comment_code']);
$config = array(
'sitename'=>$sitename,
'siteurl'=>$siteurl,
'sitedesc'=>$sitedesc,
'author'=>$author,
'pass'=>$pass,
'site_keywords'=>$site_keywords,
'site_keydesc'=>$site_keydesc,
'comment_code'=>$comment_code,
'theme_name'=>'default',
'rewrite'=>0,
'post_pre'=>'read',
'post_ex'=>'.htm');

$post = array(
'title'=>"欢迎使用QTLIGHT",
'content'=>"当您看到这篇日志，表示您已经成功安装好了QTLIGHT。

现在您就可以轻松的开始您的博客之旅了。

QTLIGHT是一个轻量级的博客系统，他采用Markdown语法撰写您的博客，所以只要花一点点时间学习下markdown语法，您就可以轻松的开始您的博客之旅了。",
'createat'=>time(),
'slug'=>"firstpost",
'state'=>"publish",
'tags'=>array('qtlight','php','sae'),
'author'=>$author,
'ip'=>getip());


$post_list = array(
'post_1'=>array(
'id'=>1,
'title'=>"欢迎使用QTLIGHT",
'content'=>"当您看到这篇日志，表示您已经成功安装好了QTLIGHT。

现在您就可以轻松的开始您的博客之旅了。",
'createat'=>time(),
'slug'=>"firstpost",
'state'=>"publish",
'tags'=>array('qtlight','php','sae'),
'author'=>$author));
$navbarcode = '* [首页](' . $siteurl . ')' . "\n" . '* [添加导航栏](' . $siteurl . '/admin/?type=navbar)';
$friendlinkcode = '* [晴天博客](http://www.qt06.com/)' . "\n" . '* [争渡网](http://zd.hk/)';
$site_count = array('total'=>1,
date('Ymd')=>1);
if(!isset($_SERVER['HTTP_APPNAME'])) {
if(!file_exists($GLOBALS['data_dir']))
mkdir($GLOBALS['data_dir'],0777,true);
}
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'config',$config);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_1',$post);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list',$post_list);
put_cnt($GLOBALS['cache_dir'] . $GLOBALS['data_pre'] . 'post_list_1',$post_list);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_qtlight',$post_list);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_php',$post_list);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_sae',$post_list);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'navbarcode',$navbarcode);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'friendlinkcode',$friendlinkcode);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'site_count',$site_count);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'install_lock','installed');
header("Location: {$siteurl}");
break;
default:
//end switch
}
//end if
}
else {
?>


<!DOCTYPE html>
<html lang="zh-cn" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>安装QTLIGHT</title>
</head>
<body>
<header>


</header>
<section>

<form method="post" action="">
<label for="sitename">博客名称</label>
<input type="text" id="sitename" name="sitename" value="" ?>
<label for="siteurl">博客网址</label>
<input type="text" id="siteurl" name="siteurl" value="" ?>
<label for="sitedesc">博客描述</label>
<input type="text" id="sitedesc" name="sitedesc" value="" ?>
<label for="site_keywords">博客关键词</label>
<input type="text" id="site_keywords" name="site_keywords" value="" />
<label for="site_keydesc">博客描述</label>
<input type="text" id="site_keydesc" name="site_keydesc" value="" />
<label for="comment_code">评论代码</label>
<textarea id="comment_code" name="comment_code"></textarea>
<label for="author">博主/管理员</label>
<input type="text" id="author" name="author" />
<label for="pass">管理密码</label>
<input type="password" id="pass" name="pass" />
<input type="hidden" name="post_type" value="config" />
<input type="submit" value="保存" />
</form>
</section>

<footer>
<p>本站由 <a href="http://qtlight.sinaapp.com/">qtlight</a> 提供动力</p>
</footer>
</body>
</html>
<?php } ?>