<?php
/****************************************************************/
/* ATutor														*/
/****************************************************************/
/* Copyright (c) 2002-2004 by Greg Gay & Joel Kronenberg        */
/* Adaptive Technology Resource Centre / University of Toronto  */
/* http://atutor.ca												*/
/*                                                              */
/* This program is free software. You can redistribute it and/or*/
/* modify it under the terms of the GNU General Public License  */
/* as published by the Free Software Foundation.				*/
/****************************************************************/

define('AT_INCLUDE_PATH', '../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');
require(AT_INCLUDE_PATH.'lib/filemanager.inc.php');

authenticate(AT_PRIV_FILES);

$current_path = AT_CONTENT_DIR.$_SESSION['course_id'].'/';

if (($_GET['popup'] == TRUE) || ($_GET['framed'] == TRUE)) {
	$_header_file = AT_INCLUDE_PATH.'fm_header.php';
	$_footer_file = AT_INCLUDE_PATH.'fm_footer.php';
} else {
	$_header_file = AT_INCLUDE_PATH.'header.inc.php';
	$_footer_file = AT_INCLUDE_PATH.'footer.inc.php';
}

if (isset($_POST['submit_no'])) {
	$msg->addFeedback('CANCELLED');
	header('Location: index.php?pathext='.$_POST['pathext'].SEP.'framed='.$_POST['framed'].SEP.'popup='.$_POST['popup']);
	exit;
}

if (isset($_POST['submit_yes'])) {
	$dest = $_POST['dest'] .'/';
	$pathext = $_POST['pathext'] .'/';

	if (isset($_POST['listofdirs'])) {

		$_dirs = explode(',',$_POST['listofdirs']);
		$count = count($_dirs);
		
		for ($i = 0; $i < $count; $i++) {
			$source = $_dirs[$i];
			@rename($current_path.$pathext.$source, $dest.$source);
		}
		$msg->addFeedback('DIRS_MOVED');
	}
	if (isset($_POST['listoffiles'])) {

		$_files = explode(',',$_POST['listoffiles']);
		$count = count($_files);

		for ($i = 0; $i < $count; $i++) {
			$source = $_files[$i];
			@rename($current_path.$pathext.$source, $current_path.$dest.$source);
		}

		$msg->addFeedback('MOVED_FILES');
	}
	header('Location: index.php?pathext='.$_POST['pathext'].SEP.'framed='.$_POST['framed'].SEP.'popup='.$_POST['popup']);
	exit;
}

if (isset($_POST['dir_chosen'])) {	
	$hidden_vars['framed']  = $_POST['framed'];
	$hidden_vars['popup']   = $_POST['popup'];
	$hidden_vars['pathext'] = $_POST['pathext'];
	$hidden_vars['dest']    = $_POST['dir_name'];

	if (isset($_POST['files'])) {
		$list_of_files = implode(',', $_POST['files']);
		$hidden_vars['listoffiles'] = $list_of_files;
		$msg->addConfirm(array('FILE_MOVE', $list_of_files), $hidden_vars);
	}
	if (isset($_POST['dirs'])) {
		$list_of_dirs = implode(',', $_POST['dirs']);
		$hidden_vars['listoffiles'] = $list_of_dirs;
		$msg->addConfirm(array('FILE_MOVE', $list_of_dirs), $hidden_vars);
	}
	require($_header_file);
	debug($_POST);
	debug($_GET);
	$msg->printConfirm();
	require($_footer_file);
} 

	require($_header_file);
	debug($_POST);
	debug($_GET);

	$tree = AT_CONTENT_DIR.$_SESSION['course_id'].'/';
	$file    = $_GET['file'];
	$pathext = $_GET['pathext']; 
	$popup   = $_GET['popup'];
	$framed  = $_GET['framed'];

	/* find the files and directories to be copied */
	$total_list = explode(',', $_GET['list']);

	$count = count($total_list);
	$countd = 0;
	$countf = 0;
	for ($i=0; $i<$count; $i++) {
		if (is_dir($current_path.$pathext.$total_list[$i])) {
			$_dirs[$countd] = $total_list[$i];
			$hidden_dirs  .= '<input type="hidden" name="dirs['.$countd.']"   value="'.$_dirs[$countd].'" />';
			$countd++;
		} else {
			$_files[$countf] = $total_list[$i];
			$hidden_files .= '<input type="hidden" name="files['.$countf.']" value="'.$_files[$countf].'" />';
			$countf++;
		}
	}

	echo '<br />';
	echo '<br />';
	//display directory tree to user
	echo '<form name="move_form" method="post" action="'.$_SERVER['PHP_SELF'].'">';
	echo '<table width=90% align="center" cellspacing="1" border="0" cellpadding="0">';
	echo '<tr><th class="cyan">' . _AT('file_manager_move') . '</th></tr>';
	echo '<tr><td class="row2" height="1"> </td></tr>';
	echo '<tr><td class="row1">' . _AT('select_directory') . '</td></tr>';
	echo '<tr><td class="row2" height="1"> </td></tr>';
	echo '<tr><td class="row1"><strong><small>';
	echo '<ul><li class="folders"><label><input type="radio" name="dir_name" value="" />Home</label>'; 
	echo display_tree($current_path, "") . '</li></ul></small></strong></td></tr>';
	echo '<tr><td class="row2" height="1"> </td></tr>';
	echo '<tr><td class="row2" height="1"> </td></tr>';
	echo '<tr><td class="row1" align = "center">';
	echo '<input type="submit" name="dir_chosen" value="'._AT('move')   . '" class="button" /> | ';
	echo '<input type="submit" name="cancel"     value="'._AT('cancel') . '" class="button" />';
	echo '</td></tr>';
	echo '<tr><td class="row2" height="1"> </td></tr>';
	echo '<input type="hidden" name="pathext" value="' . $pathext.'" />';
	echo '<input type="hidden" name="framed" value="'.$framed.'" />';
	echo '<input type="hidden" name="popup" value="'.$popup.'" />';
	echo $hidden_dirs;
	echo $hidden_files; 
	echo '</table></form>';

	echo '<br /><br /><hr size="4" width="100%">';

	require($_footer_file);
?>
