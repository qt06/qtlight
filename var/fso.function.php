<?php

/**
* qtlight
* author: qingtian
* E-mail: qt06.com@139.com
* website: http://www.qt06.com/
* qq:115928478
* 
*/

// get content
function get_cnt($k) {
	return file_exists($k) ? unserialize(file_get_contents($k)) : false;
}

//put content
function put_cnt($k,$v) {
	return file_put_contents($k,serialize($v),LOCK_EX);
}

//delete contents
function del_cnt($k) {
	return unlink($k);
}
