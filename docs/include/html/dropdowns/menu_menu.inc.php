<?php
/************************************************************************/
/* ATutor																*/
/************************************************************************/
/* Copyright (c) 2002-2005 by Greg Gay, Joel Kronenberg & Heidi Hazelton*/
/* Adaptive Technology Resource Centre / University of Toronto			*/
/* http://atutor.ca														*/
/*																		*/
/* This program is free software. You can redistribute it and/or		*/
/* modify it under the terms of the GNU General Public License			*/
/* as published by the Free Software Foundation.						*/
/************************************************************************/
// $Id$

if (!defined('AT_INCLUDE_PATH')) { exit; }
global $_base_path;
global $savant;
global $contentManager;

ob_start();

echo '<div style="whitespace:nowrap;">';

echo '<a href="'.$_base_path.'index.php">'._AT('home').'</a><br />';

/* @See classes/ContentManager.class.php	*/
$contentManager->printMainMenu();

echo '</div>';

$savant->assign('tmpl_dropdown_contents', ob_get_contents());
ob_end_clean();
$savant->assign('title', _AT('content_navigation'));
$savant->display('include/box.tmpl.php');
?>