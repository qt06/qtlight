<?php
if(!defined('qtlight_adm')) {
exit('no accessied');
}

if(isset($_POST['post_type'])) {
switch($_POST['post_type']) {
case 'post':
$title= trim($_POST['title']);
$content = get_magic_quotes_gpc() ? stripslashes(trim($_POST['content'])) : trim($_POST['content']);
$tags = explode(',',trim($_POST['tags'],','));
$createat = strtotime($_POST['post_time']);
$slug = trim($_POST['slug']);
$state = trim($_POST['state']);
$author = $GLOBALS['config']['author'];
$ip = getip();
$edit = $_POST['edit'];
$id = $_POST['id'];
$o_tags = explode(',',$_POST['o_tags']);
if($title=="" && $content=="") {
header("Location: http://qtlight.sinaapp.com/admin/");
exit;
}
$post = compact('title','content','tags','createat','slug','state','author','ip');
$post_list = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list');
if($edit!="edit") {
$oid = end($post_list);
$id = $oid['id'] +1;
}
$post_list['post_'.$id] = array('id'=>$id,'title'=>$title,'content'=>substr($content,0,280),'tags'=>$tags,'createat'=>$createat,'author'=>$GLOBALS['config']['author']);

foreach($tags as $v) {
$tag = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'. $v);
if(is_array($tag)) {
$tag['post_'.$id] = $post_list['post_'.$id];
}
else {
$tag = array();
$tag['post_'.$id] = $post_list['post_'.$id];
}
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'.$v,$tag);
}
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_' . $id,$post);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list',$post_list);
create_cache();
if($edit=="edit") {
$tags = array_flip($tags);
foreach($o_tags as $tag) {
if(!array_key_exists($tag,$tags)) {
$d_tags = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'. $tag);
unset($d_tags['post_'.$id]);
if(count($d_tags) ==0) {
del_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'. $tag);
}
else {
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'. $tag,$d_tags);
}
}
}
}
break;
case 'config':
$GLOBALS['config']['sitename'] = trim($_POST['sitename']);
$GLOBALS['config']['siteurl'] = trim($_POST['siteurl']);
$GLOBALS['config']['sitedesc'] = trim($_POST['sitedesc']);
$GLOBALS['config']['author'] = trim($_POST['author']);
$GLOBALS['config']['site_keywords'] = trim($_POST['site_keywords']);
$GLOBALS['config']['site_keydesc'] = trim($_POST['site_keydesc']);
$GLOBALS['config']['comment_code'] = get_magic_quotes_gpc() ? stripslashes(trim($_POST['comment_code'])) : trim($_POST['comment_code']);
$GLOBALS['config']['theme_name'] = trim($_POST['theme_name']);
$GLOBALS['config']['rewrite'] = trim($_POST['rewrite']);
$GLOBALS['config']['post_pre'] = trim($_POST['post_pre']);
if(($post_pre == "page") || ($post_pre == "tag"))
exit("can't to set the post_pre");
$GLOBALS['config']['post_ex'] = trim($_POST['post_ex']);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'config',$GLOBALS['config']);
break;
case 'navbar':
$navbarcode = trim($_POST['navbarcode']);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'navbarcode',$navbarcode);
break;
case 'frlink':
$friendlinkcode = trim($_POST['friendlinkcode']);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'friendlinkcode',$friendlinkcode);
break;
case 'alogin':
if($_POST['username'] == $GLOBALS['config']['author'] && md5($_POST['pass']) == $GLOBALS['config']['pass']) {
setcookie("admin","admin",time()+3600*24*30,'/',$SERVER['HTTP_HOST']);
header("Location: {$SERVER['PHP_SELF']}");
}
break;
case 'chpass':
$old_pass = md5($_POST['old_pass']);
$new_pass = $_POST['new_pass'];
$again_pass = $_POST['again_pass'];
if($old_pass == $GLOBALS['config']['pass']) {
if($new_pass == $again_pass) {
$GLOBALS['config']['pass'] = md5($new_pass);
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'config',$GLOBALS['config']);
echo "密码修改成功，请使用新密码重新登陆。";
header("Location: {$SERVER['PHP_SELF']}?type=quit");
}
else {
echo "密码修改失败。";
}
}
else {
echo "旧密码输入错误";
}
break;
default:
//end switch
}
//end if
}
