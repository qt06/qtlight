<?php
include('form.php');
$f = new form('index.php','post');
$f->create_password('old_pass','旧密码：','请填写您的旧密码');
$f->create_password('new_pass','新密码：','请填写您的新密码');
$f->create_password('again_pass','重复新密码：','请再次填写一次您的新密码');
$f->create_hidden('post_type','chpass');
$f->create_submit('submit_btn','保存');
$f->show();
