<?php
include('form.php');
$f = new form('index.php','post');
$f->create_textarea('friendlinkcode','友情链接代码',$friendlinkcode,'请在这里填写友情链接代码，请使用Markdown语法书写。<br />有关Markdown语法，请参看<a href="http://markdown.tw/" target="_blank">Markdown语法说明</a>');
$f->create_hidden('post_type','frlink');
$f->create_submit('submit_btn','保存');
$f->show();
