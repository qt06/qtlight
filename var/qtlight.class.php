<?php
include('markdown.php');
class options
{
private $config;
function __construct() {
$this->config = $GLOBALS[$GLOBALS['data_pre'] . 'config'];
}


//sitename
function title() {
echo $this->config['sitename'];
}

//siteurl
function siteurl() {
echo $this->config['siteurl'];
}

//site description
function description() {
echo $this->config['sitedesc'];
}

//site keywords
function keywords() {
echo $this->config['site_keywords'];
}

//site key description
function keydesc() {
echo $this->config['site_keydesc'];
}


//comment code
function comment_code() {
echo $this->config['comment_code'];
}

//theme name
function themeDir() {
return __QTLIGHT_ROOT_DIR__ . __QTLIGHT_THEME_DIR__ . '/' . $this->config['theme_name'] . '/';
}

function themeUrl($file) {
echo $this->config['siteurl'] . __QTLIGHT_THEME_DIR__ . '/' . $this->config['theme_name'] . '/' . $file;
}

function rewrite() {
if($this->config['rewrite'] == 0)
return false;
if($this->config['rewrite'] ==1)
return true;
}

function post_pre() {
return $this->config['post_pre'];
}

function post_ex() {
return $this->config['post_ex'];
}

//end options class
}

class tpl
{
private $options;
private $post_list;
public $post;
public $cookie_admin;
public $page_type;
public $curpage;

function __construct($post_list,$curpage,$page_type=null) {
$this->options = new options();
$this->post_list = $post_list;
$this->post = current($this->post_list);
$this->curpage = $curpage;
$this->page_type = $page_type;
$this->cookie_admin = isset($_COOKIE['admin']) ?$_COOKIE['admin'] : "";
}
function next() {
$this->post = next($this->post_list);
if($this->post) {
return true;
}
else {
return false;
}
}

function is($page_type) {
return $this->page_type == $page_type;
}

function display($tplname) {
$this->need($tplname);
}
function need($tplname) {
include $this->options->themeDir() . $tplname;
}


function pagenav() {
$npage = $this->curpage + 1;
$ppage = $this->curpage - 1;
if($ppage > 0) {
echo '<a href="';
$this->options->siteurl();
if(!$this->options->rewrite())
echo '/index.php';
echo '/page/' . $ppage . '" accesskey="b">上一页</a>';
}
echo '<a href="';
$this->options->siteurl();
if(!$this->options->rewrite())
echo '/index.php';
echo '/page/' . $npage . '" accesskey="n">下一页</a>';
}

function edit() {
if($this->cookie_admin) {
echo '<a href="';
$this->options->siteurl();
echo __QTLIGHT_ADMIN_DIR__ . '?type=post&amp;id=' . $this->post['id'] . '">编辑</a>';
}
}
function content() {
echo markdown($this->post['content']);
}

function title() {
echo $this->post['title'];
}

function author() {
echo $this->post['author'];
}
function date($format="Y-m-d") {
echo date($format,$this->post['createat']);
}


function tag() {
$tags = $this->post['tags'];
foreach($tags as $tag) {
if($tag == "")
echo 'none';
else {
echo '<a href="';
$this->options->siteurl();
if(!$this->options->rewrite())
echo '/index.php';
echo '/tag/' . urlencode($tag) .'">' . $tag .'</a>';
}
}
}


function permalink() {
$this->options->siteurl();
if(!$this->options->rewrite())
echo '/index.php';
echo '/' . $this->options->post_pre() . '/' . $this->post['id'] . $this->options->post_ex();
}


function comment_code() {
$this->options->comment_code();
}

function header() {
echo '<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
echo '<meta name="keywords" content="';
$this->options->keywords();
echo '" />';
echo '<meta name="description" content="';
$this->options->keydesc();
echo '" />';
}

function randompost() {

$post_list = get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'post_list');
if(count($post_list) > 5) {
$rand_key = array_rand($post_list,5);
$cnt = count($rand_key);
for($i = 0;$i<$cnt;$i++) {
echo '<li><a href="';
$this->options->siteurl();
echo '/post/' . $post_list[$rand_key[$i]]['id'] .'">';
echo $post_list[$rand_key[$i]]['title'] . '</a></li>';
}
}
}

function footer() {
$site_count = qtlight_site_count();
echo "今日访问：".$site_count[date('Ymd')]."次，总访问：" .$site_count['total'] ."次";
echo '，页面执行时间：';
echo timespent();
echo '毫秒。';
}

function navbar() {
echo markdown($GLOBALS[$GLOBALS['data_pre'] . 'navbarcode']);
}

function friendlink() {
echo markdown($GLOBALS[$GLOBALS['data_pre'] . 'friendlinkcode']);
}

//end class
}
