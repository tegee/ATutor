<?php
/****************************************************************************/
/* ATutor																	*/
/****************************************************************************/
/* Copyright (c) 2002-2010                                                  */
/* Inclusive Design Institute                                               */
/* http://atutor.ca															*/
/*																			*/
/* This program is free software. You can redistribute it and/or			*/
/* modify it under the terms of the GNU General Public License				*/
/* as published by the Free Software Foundation.							*/
/****************************************************************************/
// $Id$

define('AT_INCLUDE_PATH', '../../../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate();

if (isset($_POST['cancel'])) {
	$msg->addFeedback('CANCELLED');
	header('Location: '.AT_BASE_HREF.'admin/index.php');
	exit;
} else if (isset($_POST['submit'])) {
	$missing_fields = array();

	/* email validation */
	if ($_POST['email'] == '') {
		$missing_fields[] = _AT('email');
	} else if (!preg_match("/^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,6}$/i", $_POST['email'])) {
		$msg->addError('EMAIL_INVALID');
	}

	$sql = "SELECT * FROM %smembers WHERE email LIKE '%s'";
	$row_email = queryDB($sql,array(TABLE_PREFIX, $_POST['email']), TRUE);
	if(count($row_email) > 0){
		$valid = 'no';
		$msg->addError('EMAIL_EXISTS');
	}

	if ($missing_fields) {
		$missing_fields = implode(', ', $missing_fields);
		$msg->addError(array('EMPTY_FIELDS', $missing_fields));
	}

	if (!$msg->containsErrors()) {
		$_POST['real_name'] = $addslashes($_POST['real_name']);
		$_POST['email']     = $addslashes($_POST['email']);

		$sql    = "UPDATE %sadmins SET real_name='%s', email='%s', last_login=last_login WHERE login='%s'";
		$result = queryDB($sql, array(TABLE_PREFIX, $_POST['real_name'], $_POST['email'], $_SESSION['login']));

		$msg->addFeedback('ACTION_COMPLETED_SUCCESSFULLY');

		header('Location: '.AT_BASE_HREF.'admin/index.php');
		exit;
	}
	$_POST['real_name']         = $stripslashes($_POST['real_name']);
	$_POST['email']             = $stripslashes($_POST['email']);
} 

require(AT_INCLUDE_PATH.'header.inc.php'); 

$sql = "SELECT real_name, email FROM %sadmins WHERE login='%s'";
$row = queryDB($sql, array(TABLE_PREFIX, $_SESSION['login']), TRUE);

if(count($row) == 0){
	$msg->addError('USER_NOT_FOUND');
	$msg->printErrors();
	require(AT_INCLUDE_PATH.'footer.inc.php');
	exit;
}
if (!isset($_POST['submit'])) {
	$_POST = $row;
//	$_POST['confirm_password'] = $_POST['password'];
}

?>

<?php 
$savant->display('admin/my_edit.tmpl.php');
require(AT_INCLUDE_PATH.'footer.inc.php'); ?>