<?php
include('form.php');
$f = new form('index.php','post');
$f->create_text('sitename','博客名称','请填写您的博客名称',array('value'=>$sitename));
$f->create_text('siteurl','博客网址','请填写您的博客地址，请用http开头，结尾不要加/',array('value'=>$siteurl));
$f->create_text('sitedesc','博客描述','请填写简短的博客描述，他一般出现在您的页面顶部。',array('value'=>$sitedesc));
$f->create_text('site_keywords','博客关键词','请填写您博客的主要关键词，用于搜索引擎。',array('value'=>$site_keywords));
$f->create_text('site_keydesc','博客关键词描述','同样用于搜索引擎，用简短的句子描述您博客可能提供的主要内容。',array('value'=>$site_keydesc));
$f->create_textarea('comment_code','评论代码',$comment_code,'请填写您的日志评论代码，可从第三方评论提供商获得，例如<a href="http://duoshuo.com/" target="_blank">多说评论框</a>等。');
$f->create_text('author','博主/管理员','请填写博客主人，这也将用于您博客后台的管理员帐号。',array('value'=>$author));
$f->create_text('theme_name','默认模板','请填写您将使用的模板的名称，一般是模板的目录名。',array('value'=>$theme_name));
$f->create_select('rewrite','地址重写',array('不开启','开启'),$rewrite,'开启地址重写功能会有利于搜索引擎收录，但需要您的空间支持方可使用。');
$f->create_text('post_pre','文章url前缀','设置此项有可能对搜索引擎收录有帮助，您可以根据自己喜好进行修改，一般默认即可。',array('value'=>$post_pre));
$f->create_text('post_ex','文章url后缀','例如.html等，可根据自己喜好修改。',array('value'=>$post_ex));
$f->create_hidden('post_type','config');
$f->create_submit('submit_btn','保存');
$f->show();
