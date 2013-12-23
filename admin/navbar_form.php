<?php
include('form.php');
$f = new form('index.php','post');
$f->create_textarea('navbarcode','顶部导航代码',$navbarcode,'请在这里填写用于在页面顶部显示的导航栏的代码，请使用Markdown语法书写。<br />有关Markdown语法，请参看<a href="http://markdown.tw/" target="_blank">Markdown语法说明</a>');
$f->create_hidden('post_type','navbar');
$f->create_submit('submit_btn','保存');
$f->show();
