<?php

/** 定义根目录 */
define('__QTLIGHT_ROOT_DIR__', dirname(__FILE__));

/** 定义数据保存目录(相对路径) */
define('__QTLIGHT_DATA_DIR__', '/usr/data');

/** 定义插件目录(相对路径) */
define('__QTLIGHT_PLUGIN_DIR__', '/usr/plugins');

/** 定义模板目录(相对路径) */
define('__QTLIGHT_THEME_DIR__', '/usr/themes');

/** 后台路径(相对路径) */
define('__QTLIGHT_ADMIN_DIR__', '/admin/');

/** 设置包含路径 */
@set_include_path(get_include_path() . PATH_SEPARATOR .
__QTLIGHT_ROOT_DIR__ . '/var' . PATH_SEPARATOR .
__QTLIGHT_ROOT_DIR__ . __QTLIGHT_PLUGIN_DIR__);

//if(isset($_SERVER['HTTP_APPNAME']))
if(defined('SAE_APPNAME'))
include('saekv.php');
else
include('fso.function.php');
include('qtlight.function.php');
include('qtlight.class.php');
$GLOBALS['data_pre'] = "qtlight_";
$GLOBALS['data_dir'] = __QTLIGHT_ROOT_DIR__ . '/' . __QTLIGHT_DATA_DIR__ . '/';
$GLOBALS['cache_dir'] = __QTLIGHT_ROOT_DIR__ . '/' . __QTLIGHT_DATA_DIR__ . '/cache/';
if(defined('SAE_APPNAME')) {
$GLOBALS['data_dir'] = "";
$GLOBALS['cache_dir'] = "qlcache_";
}
//if(!get_cnt($GLOBALS['data_dir'] . $GLOBALS['data_pre'] . 'install_lock')) exit(header("Location: install.php"));
