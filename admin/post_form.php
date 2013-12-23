<?php
include('form.php');
$f = new form('index.php','post');
$f->create_text('title','标题','请填写文章标题',array('value'=>$title));
$f->create_textarea('content','内容',$content,'请在这里撰写您的博文内容，请使用Markdown语法书写。<br />有关Markdown语法，请参看<a href="http://markdown.tw/" target="_blank">Markdown语法说明</a>');
$f->create_text('tags','标签','请用西文逗号分隔',array('value'=>$tags));
$f->create_text('post_time','发布时间','文章发布时间，可自定义',array('value'=>$time));
$f->create_text('slug','网址别名','',array('value'=>$slug));
$f->create_select('state','状态',array('post'=>'发布','draft'=>'草稿'),$state,'可选择发布或者草稿');
$f->create_hidden('id',$id);
$f->create_hidden('o_tags',$tags);
$f->create_hidden('edit',$edit);
$f->create_hidden('post_type','post');
$f->create_submit('submit_btn','保存');
$f->show();
