<?php
include('config.inc.php');


//set_error_handler("qt_error");

qtlight_init();
distribute();

echo '<!-- today:' . $GLOBALS[$GLOBALS['data_pre'] . 'site_count'][date('Ymd')] . ',total:' . $GLOBALS[$GLOBALS['data_pre'] . 'site_count']['total'] . '. spent:' . timespent() .'ms -->';
