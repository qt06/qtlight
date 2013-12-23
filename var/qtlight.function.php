<?php

/**
* qtlight
* author: qingtian
* E-mail: qt06.com@139.com
* website: http://www.qt06.com/
* qq:115928478
* 
*/

function get_microtime() {
  list($usec, $sec) = explode(' ', microtime());
  return ((float)$usec + (float)$sec);
}

function timespent() {
  $stoptime = get_microtime();
  return round(($stoptime - $GLOBALS['starttime']) * 1000, 1);
}

// get ip
function getip(){
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $cip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
elseif(!empty($_SERVER["REMOTE_ADDR"])){
  $cip = $_SERVER["REMOTE_ADDR"];
}
else{
  $cip = "no ip";
}
return $cip;
}

function get_g($c) {

if($GLOBALS[$c])
return $GLOBALS[$c];
else
return false;
}

function qtlight_init() {
	$dir = $GLOBALS['data_dir'] . $GLOBALS['data_pre'];
	$GLOBALS['starttime'] = get_microtime();
	if(defined('SAE_APPNAME')) {
		$rs = mget_cnt(array($dir . 'config', $dir . 'site_count', $dir . 'navbarcode', $dir . 'friendlinkcode'));
		foreach($rs as $k => $v) {
			//$k = substr($k,strlen($GLOBALS['data_pre']));
			$GLOBALS[$k] = $v;
		}
	}
	else {
		$GLOBALS[$GLOBALS['data_pre'] . 'config'] = get_cnt($dir . 'config');
		$GLOBALS[$GLOBALS['data_pre'] . 'site_count'] = get_cnt($dir . 'site_count');
		$GLOBALS[$GLOBALS['data_pre'] . 'navbarcode'] = get_cnt($dir . 'navbarcode');
		$GLOBALS[$GLOBALS['data_pre'] . 'friendlinkcode'] = get_cnt($dir . 'friendlinkcode');
	}
	qtlight_site_count();
}

/**
* 路由分配
* 根据PATH_INFO 所分割的字符串调用相应的处理函数
*/
function distribute() {
		
		$qs = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'],'/') : "";
if($len = stripos($qs,$GLOBALS[$GLOBALS['data_pre'] . 'config']['post_ex']))
$qs = substr($qs,0,$len);


		$qs = explode('/',$qs);
		if(empty($qs[0]))
				$qs = array('page',1);
				if($qs[0] =='tag')
						call_user_func_array('tag',array_slice($qs,1));
				if($qs[0] == 'page')
						call_user_func_array('page',array_slice($qs,1));
				if($qs[0] == $GLOBALS[$GLOBALS['data_pre'] . 'config']['post_pre'])
						call_user_func_array('post',array_slice($qs,1));
}


/**
* 错误处理函数
* 调试模式返回所有错误
* 生产模式直接返回404
*/
function qt_error() {
		
		if($GLOBALS['mode'] == "debug") {
				error_reporting(E_ALL);
		}
		else {
				echo "error";
		}
}


// site count begin
function qtlight_site_count() {
$today = date("Ymd");
$GLOBALS[$GLOBALS['data_pre'] . 'site_count'][$today] = $GLOBALS[$GLOBALS['data_pre'] . 'site_count'][$today] + 1;
$GLOBALS[$GLOBALS['data_pre'] . 'site_count']['total'] = $GLOBALS[$GLOBALS['data_pre'] . 'site_count']['total'] + 1;
put_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'site_count',$GLOBALS[$GLOBALS['data_pre'] . 'site_count']);
}
//site count end

//create cache
function create_cache() {

$post_list_cache = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list');
$post_list_cache = array_reverse($post_list_cache);
$cache_tmp = array_chunk($post_list_cache,5,true);
foreach($cache_tmp as $k => $v) {
put_cnt($GLOBALS['cache_dir'] . $GLOBALS['data_pre'] . 'post_list_' . ($k + 1),$v);
}
}

//end create cache

function qtlight_cache($id) {

$content = get_cnt($GLOBALS['cache_dir'] . $GLOBALS['data_pre'] . 'post_'.$id);
if($content) {
$content = str_replace('</body>',timespent() . '</body>',$content);
exit($content);
}
}


function tag($tag = null) {
if(!$tag)
return;

$tag_list = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'tag_'.urldecode($tag));
$tag_list = is_array($tag_list) ? array_reverse($tag_list) : array();

if(!empty($tag_list)) {
array_unshift($tag_list,array('title'=>urldecode($tag)));
$show = new tpl($tag_list,'tag');
$show->display('index.php');
}
else {
echo "no found the tag" . rawurldecode($tag);
}
}


function page($num) {

$post_list = get_cnt($GLOBALS['cache_dir'] . $GLOBALS['data_pre'] . 'post_list_' . $num);
if(!empty($post_list)) {
//$post_list = array_reverse($post_list);
$title = ($num == 1) ? '首页' : '第' . $num . '页';
array_unshift($post_list,array('title'=>$title));
$show = new tpl($post_list,$num,'index');
$show->display('index.php');
}
else {
echo "no found";
}
}
function post($id) {
//qtlight_cache($id);
//ob_start();

$post = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_'.$id);
if(!empty($post)) {
$post['id'] = $id;
$show = new tpl(array($post),'post');
$show->display('post.php');


}
else {
echo "the post is no found";
}
}


function pageNav() {

$page_num = 5;
$post_list = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list');
$count = count($post_list);
if($count%$page_num!=0)
$pcount = ceil($count/$page_num);
else $pcount = $count/$page_num;
for($i=0;$i<=$pcount;$i++) {
echo '<a href="' .$GLOBALS['config']['siteurl'] . '/page/' . $i . '">' . $i . '</a>';
}
}
