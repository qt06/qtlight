<?php
/**
* create form elements
* 
* author: qingtian
* website: http://www.qt06.com/
*/


class form
{

private $element_array = array();
private $begin_form = null;
private $end_form = null;
private $action = null;
private $method = null;


function __construct($action=null,$method=null,$otherparams= array()) {
	if(!null == $action) $this->action = $action;
	if(!null == $method) $this->method = $method;
	$this->begin_form = '<form action="' . $this->action . '" method="' . $this->method . '"';
	if(!empty($otherparams))
		$this->begin_form .= $this->part($otherparams);
	$this->begin_form .='>' . "\n";
	$this->end_form = '</form>' . "\n";
}

private function part($params=array()) {
	if(!empty($params)) {
		$part = ' ';
		foreach($params as $k => $v) {
			$part .= $k . '="' . $v . '" ';
		}
		return $part;
	}
	return false;
}

private function create_input($type='button',$name=null,$value=null,$otherparams=array()) {
	$input = '<p><input';
	$arr = array_merge(array('type'=>$type,'name'=>$name,'id'=>$name,'value'=>$value),$otherparams);
	$input .= $this->part($arr);
	$input .= '/></p>';
	$this->element_array[] = $input;
	return $input;
}

function create_text($name,$label,$description= null,$otherparams = array(),$type='text') {
	if($name == "") return false;
	if($label == "") return false;
	$input = '<p><label for="' . $name . '">' . $label . '</label>' . "\n";
	$input .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . '"';
	$input .= $this->part($otherparams);
	$input .= '/>' . "\n";
	if($description != null) $input .= '<div>' . $description . '</div>';
	$input .= "\n" . '</p>';
	$this->element_array[] = $input;
	return $input;
}

function create_password($name,$label,$description=null,$otherparams = array()) {
	return $this->create_text($name,$label,$description,$otherparams=array(),'password');
}

function create_checkbox($name,$label,$options,$defaultchecked,$description,$otherparams=array(),$type='checkbox') {
if($name == "" ) return false;
$checkbox = '<p>';
$i =0;
foreach($options as $k => $v) {
$checkbox .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . $i . '" value="' . $k . '" ' . $this->part($otherparams);
if($k == $defaultchecked) $checkbox.='checked />';
else $checkbox .='/>';
$checkbox .= "\n" . '<label for="' . $name . $i . '">' . $v . '</label>' . "\n";
$i++;
}
$checkbox .= '<div>' . $description . '</div></p>';
$this->element_array[] = $checkbox;
return $checkbox;
}

function create_radio($name,$label,$options,$defaultchecked,$description,$otherparams=array()) {
return $this->create_checkbox($name,$label,$options,$defaultchecked,$description,$otherparams,$type='radio');
}

function create_select($name,$label,$options,$defaultselected,$description,$otherparams = array()) {
	if($name == "") return false;
	if($label == "") return false;
	$select = '<p><label for="' . $name . '">' . $label . '"</label>' . "\n" . '<select name="' . $name . '" id="' . $name . '"' . $this->part($otherparams) . '>';
	$opts = '';
	foreach($options as $k => $v) {
		$opts .= '<option value="' . $k . '"';
		if($k == $defaultselected)
			$opts .= ' selected>';
		else
			$opts .= '>';
		$opts .= $v . '</option>' . "\n";
	}
	$select .= $opts;
	$select .= '</select><div>' . $description . '</div></p>';
	$this->element_array[] = $select;
	return $select;
}

function create_button($name,$value) {
	if($value == "") return false;
	return $this->create_input('button',$name,$value);
}

function create_hidden($name,$value) {
if($name == "") return false;
return $this->create_input('hidden',$name,$value);
}

function create_submit($name,$value) {
	if($value == "") return false;
	return $this->create_input('submit',$name,$value);
}

function create_reset($name,$value) {
	if($value == "") return false;
	return $this->create_input('reset',$name,$value);
}

function create_textarea($name,$label,$defaultvalue,$description = "",$otherparams=array()) {
	if($name == "") return false;
	$textarea = '<p><label for="' . $name . '">' . $label . '</label><textarea name="' . $name . '" id="' . $name . '"' . $this->part($otherparams);
	$textarea .= '>' . $defaultvalue . '</textarea><div>' . $description . '</div></p>';
	$this->element_array[] = $textarea;
	return $textarea;
}

function show() {
	echo $this->begin_form;
	echo implode("\n",$this->element_array);
	echo $this->end_form;
}


//end form class
}
