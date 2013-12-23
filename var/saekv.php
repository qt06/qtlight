<?php

/**
* qtlight
* author: qingtian
* E-mail: qt06.com@139.com
* website: http://www.qt06.com/
* qq:115928478
* 
*/

// begin sina kvdb functions
function kv_init() {
		global $_g;
		if($_g['kv']==false) {
				$kv = new SaeKV();
				if($kv->init()) {
						$_g['kv'] = $kv;
						return $_g['kv'];
				}
				else {
					return false;
				}
		}
		else {
				return $_g['kv'];
		}
}
function kv_add($k,$v) {
$kv = kv_init();
return $kv->add($k,$v) ?true : false;
}
function kv_set($k,$v) {
$kv = kv_init();
return $kv->set($k,$v) ?true :false;
}
function kv_replace($k,$v) {
$kv = kv_init();
return $kv->replace($k,$v) ? true : false;
}
function kv_get($k) {
$kv = kv_init();
return $kv->get($k);
}
function kv_mget($k) {
$kv = kv_init();
return $kv->mget($k);
}
function kv_pkrget($k,$n) {
$kv = kv_init();
return $kv->pkrget($k,$n);
}
function kv_del($k) {
$kv = kv_init();
return $kv->delete($k) ?true :false;
}
function kv_get_options() {
$kv = kv_init();
return $kv->get_options();
}
function kv_set_options($opts) {
return $kv->set_options($opts);
}
// end sina kvdb functions

// get content
function get_cnt($k) {
	return kv_get($k);
}

// get multi content
function mget_cnt($k) {
return kv_mget($k);
}

//put content
function put_cnt($k,$v) {
	return kv_set($k,$v);
}

//delete contents
function del_cnt($k) {
	return kv_del($k);
}
