<?php
if (!defined('AT_INCLUDE_PATH')) { exit; }

/* available header.tmpl.php variables:
 *
 * ======================================
 * top_level_pages           array(array('url', 'title'))     the top level pages. ATutor default creates tabs.
 * section_title             string                           the name of the current section. either name of the course, administration, my start page, etc.
 * page_title                string                           the title of the current page.
 * path                      array(array('url', 'title'))     the path to the current page.
 * back_to_page              array('url', 'title')            the link back to the part of the current page, if needed.
 * current_top_level_page    string                           full url to the current top level page in "top_leve_pages"
 * current_sub_level_page    string                           full url to the current sub level page in the "sub_level_pages"
 * sub_level_pages           array(array('url', 'title'))     the sub level pages.
 */

// will have to be moved to the header.inc.php
global $system_courses;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $this->tmpl_lang; ?>">
<head>
	<title><?php echo SITE_NAME; ?> : <?php echo $this->page_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->tmpl_charset; ?>" />
	<meta name="Generator" content="ATutor - Copyright 2005 by http://atutor.ca" />
	<base href="<?php echo $this->tmpl_content_base_href; ?>" />
	<link rel="shortcut icon" href="<?php echo $this->tmpl_base_path; ?>favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo $this->tmpl_base_path.'themes/'.$this->tmpl_theme; ?>/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="<?php echo $this->tmpl_base_path.'themes/'.$this->tmpl_theme; ?>/styles.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->tmpl_base_path.'themes/'.$this->tmpl_theme; ?>/forms.css" type="text/css" />
	<?php echo $this->tmpl_rtl_css; ?>
	<style type="text/css"><?php echo $this->tmpl_banner_style; ?></style>
	<?php if ($system_courses[$_SESSION['course_id']]['rss']): ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo SITE_NAME; ?> - RSS 2.0" href="<?php echo $this->tmpl_base_href; ?>get_rss.php?<?php echo $_SESSION['course_id']; ?>-2" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo SITE_NAME; ?> - RSS 1.0" href="<?php echo $this->tmpl_base_href; ?>get_rss.php?<?php echo $_SESSION['course_id']; ?>-1" />
	<?php endif; ?>
</head>
<body onload="setstates(); <?php echo $this->tmpl_onload; ?>"><div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script language="JavaScript" src="<?php echo $this->tmpl_base_path; ?>overlib.js" type="text/javascript"></script><script language="javascript" type="text/javascript">
//<!--
function getexpirydate(nodays){
	var UTCstring;
	Today = new Date();
	nomilli=Date.parse(Today);
	Today.setTime(nomilli+nodays*24*60*60*1000);
	UTCstring = Today.toUTCString();
	return UTCstring;
}

function setcookie(name,value,duration){
	cookiestring=name+"="+escape(value)+";path=/;expires="+getexpirydate(duration);
	document.cookie=cookiestring;
	if(!getcookie(name)){
		return false;
	} else {
		return true;
	}
}

function getcookie(cookiename) {
	var cookiestring=""+document.cookie;
	var index1=cookiestring.indexOf(cookiename);
	if (index1==-1 || cookiename=="") return ""; 
	var index2=cookiestring.indexOf(';',index1);
	if (index2==-1) index2=cookiestring.length; 
	return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
}

function setDisplay(objId) {
	var toc = document.getElementById(objId);

	var state = getcookie(objId);
	if (document.getElementById(objId) && state && (state == 'none')) {
		toggleToc(objId);
	}
}


function setstates() {
	return;
	var objId = "side-menu";
	var state = getcookie(objId);
	if (document.getElementById(objId) && state && (state == 'none')) {
		toggleToc(objId);
	}

	var objId = "toccontent";
	var state = getcookie(objId);
	if (document.getElementById(objId) && state && (state == 'none')) {
		toggleToc(objId);
	}

}

function showTocToggle(objId, show, hide, key, selected) {
	if(document.getElementById) {
		if (key) {
			var accesskey = " accesskey='" + key + "' title='Alt - "+ key +"'";
		} else {
			var accesskey = "";
		}

		if (selected == 'hide') {
			document.writeln(' - <a href="javascript:toggleToc(\'' + objId + '\')" ' + accesskey + '>' +
			'<span id="' + objId + 'showlink" style="display:none;">' + show + '</span>' +
			'<span id="' + objId + 'hidelink">' + hide + '</span>'	+ '</a>');
		} else {
			document.writeln(' - <a href="javascript:toggleToc(\'' + objId + '\')" ' + accesskey + '>' +
			'<span id="' + objId + 'showlink">' + show + '</span>' +
			'<span id="' + objId + 'hidelink" style="display:none;">' + hide + '</span>'	+ '</a>');
		}
	}
}

function toggleToc(objId) {
	var toc = document.getElementById(objId);
	if (toc == null) {
		return;
	}
	var showlink=document.getElementById(objId + 'showlink');
	var hidelink=document.getElementById(objId + 'hidelink');
	if (hidelink.style.display == 'none') {
		toc.style.display = '';
		hidelink.style.display='';
		showlink.style.display='none';
	} else {
		toc.style.display = 'none';
		hidelink.style.display='none';
		showlink.style.display='';
	}
	setcookie(objId, toc.style.display, 1);
}
//-->
</script>
<!-- the bread crumbs -->
<div id="breadcrumbs">
	<div style="float: right; color: #5E6D89;">
		<!-- hidden direct link to content -->
		<a href="<?php echo $_SERVER['REQUEST_URI']; ?>#content" style="border: 0px;"><img src="<?php echo $this->tmpl_base_path; ?>images/clr.gif" height="1" width="1" border="0" alt="<?php echo _AT('goto_content'); ?>" /></a>

		<?php if ($_SESSION['valid_user']): ?>
			<img src="<?php echo $this->img;?>user-star.gif" style="vertical-align: bottom;" alt="" /><strong style="color: white;"><?php echo $_SESSION['login']; ?></strong>  |
			<a href="<?php echo $this->tmpl_base_path; ?>search.php"><?php echo _AT('search'); ?></a> | 
			<a href="<?php echo $this->tmpl_base_path; ?>help/index.php"><?php echo _AT('help'); ?></a> |
			<a href="<?php echo $this->tmpl_base_path; ?>logout.php"><?php echo _AT('logout'); ?></a>
		<?php else: ?>
			<a href="<?php echo $this->tmpl_base_path; ?>login.php?course=<?php echo $_SESSION['course_id']; ?>"><?php echo _AT('login'); ?></a> | 
 			<a href="<?php echo $this->tmpl_base_path; ?>search.php"><?php echo _AT('search'); ?></a> | 
			<a href="<?php echo $this->tmpl_base_path; ?>help/index.php"><?php echo _AT('help'); ?></a>
		<?php endif; ?>
	</div>

	<small><?php echo _AT('back_to'); ?>
	<?php foreach ($this->path as $page): ?>
		<a href="<?php echo $page['url']; ?>"><?php echo $page['title']; ?></a> � 
	<?php endforeach; ?> <?php echo $this->page_title; ?></small>
</div>
<div style="background-color:#788CB3; padding-top: 2px; padding-right: 5px;">
	<?php if (isset($_SESSION['course_id']) && ($_SESSION['course_id'] >= 0)): ?>
			<!-- start the jump menu -->
			<div style="float: right;" id="jump-area">
			<?php if (empty($_GET)): ?>
				<form method="post" action="<?php echo $this->tmpl_base_path; ?>bounce.php?p=<?php echo urlencode($this->tmpl_rel_url); ?>" target="_top">
			<?php else: ?>
				<form method="post" action="<?php echo $this->tmpl_base_path; ?>bounce.php" target="_top">
			<?php endif; ?>
			<label for="jumpmenu" accesskey="j"></label>
				<select name="course" id="jumpmenu" title="<?php echo _AT('jump'); ?>:  Alt-j">							
					<option value="0" id="start-page"><?php echo _AT('my_start_page'); ?></option>
					<optgroup label="<?php echo _AT('courses_below'); ?>">
						<?php foreach ($this->tmpl_nav_courses as $this_course_id => $this_course_title): ?>
							<option value="<?php echo $this_course_id; ?>"><?php echo $this_course_title; ?></option>
						<?php endforeach; ?>
					</optgroup>
				</select> <input type="submit" name="jump" value="<?php echo _AT('jump'); ?>" id="jump-button" /></form>
			<!-- /end the jump menu -->
			</div>
	<?php endif; ?>

	<!-- section title -->
	<h1 id="section-title"><?php echo $this->section_title; ?>
	<?php if (($_SESSION['course_id'] > 0) && ($_SESSION['enroll'] == AT_ENROLL_NO)) : ?>
		- <a href="<?php echo $this->tmpl_base_path; ?>enroll.php?course=<?php echo $_SESSION['course_id']; ?>"><?php echo _AT('enroll'); ?></a></small>
	<?php endif; ?></h1>
</div>

<!-- the main navigation. in our case, tabs -->
<table class="tabbed-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th id="left-empty-tab">&nbsp;</th>
	<?php foreach ($this->top_level_pages as $page): ?>
		<?php if ($page['url'] == $this->current_top_level_page): ?>
			<th class="selected"><a href="<?php echo $page['url']; ?>" accesskey="<?php echo ++$accesscounter; ?>"><?php echo $page['title']; ?></a></th>
			<th class="tab-spacer">&nbsp;</th>
		<?php else: ?>
			<th class="tab"><a href="<?php echo $page['url']; ?>" accesskey="<?php echo ++$accesscounter; ?>"><?php echo $page['title']; ?></a></th>
			<th class="tab-spacer">&nbsp;</th>
		<?php endif; ?>
	<?php endforeach; ?>
	<th id="right-empty-tab">&nbsp;</th>
	</tr>
	</table>

<!-- the sub navigation -->
<div style="float: right; padding-top: 5px; padding-right: 5px;"><small><?php echo $this->tmpl_current_date; ?></small></div>
<?php if ($this->sub_level_pages): ?>
	<div id="sub-navigation">
		<?php if (isset($this->back_to_page)): ?>
			<a href="<?php echo $this->back_to_page['url']; ?>" id="back-to">Back to <?php echo $this->back_to_page['title']; ?></a> | 
		<?php endif; ?>

		<?php $num_pages = count($this->sub_level_pages); ?>
		<?php for($i=0; $i<$num_pages; $i++): ?>
			<?php if ($this->sub_level_pages[$i]['url'] == $this->current_sub_level_page): ?>
				<strong><?php echo $this->sub_level_pages[$i]['title']; ?></strong>
			<?php else: ?>
				<a href="<?php echo $this->sub_level_pages[$i]['url']; ?>"><?php echo $this->sub_level_pages[$i]['title']; ?></a>
			<?php endif; ?>
			<?php if ($i < $num_pages-1): ?>
				|
			<?php endif; ?>
		<?php endfor; ?>
	</div>
<?php else: ?>
	<div id="sub-navigation">
		&nbsp;
	</div>
<?php endif; ?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<?php if ($_SESSION['course_id'] > 0): ?>
			<td valign="top" width="100%">
		<?php else: ?>
			<td valign="top" width="100%" colspan="2">
		<?php endif; ?>

<!-- the page title -->
	<?php if ($this->sequence_links): ?>
		<div id="sequence-links">
			<?php if ($this->sequence_links['resume']): ?>
				<a href="<?php echo $this->sequence_links['resume']['url']; ?>" accesskey="."><img src="http://www.utoronto.ca/atrc/stuff/atutor_icons/continue.gif" border="0" align="middle" alt="" class="img-size-prevnext" /> <?php echo $this->sequence_links['resume']['title']; ?></a>
			<?php else: ?>
				<?php if ($this->sequence_links['previous'] && $this->sequence_links['next']): ?>
					<a href="<?php echo $this->sequence_links['previous']['url']; ?>" accesskey=","><img src="http://www.utoronto.ca/atrc/stuff/atutor_icons/previous.gif" border="0" align="middle" alt="" class="relimg-prevnext" /> <?php echo $this->sequence_links['previous']['title']; ?></a>
					|
					<a href="<?php echo $this->sequence_links['next']['url']; ?>" accesskey="."><?php echo $this->sequence_links['next']['title']; ?> <img src="http://www.utoronto.ca/atrc/stuff/atutor_icons/next.gif" border="0" align="middle" alt="" class="relimg-prevnext" /></a>
				<?php elseif ($this->sequence_links['previous']): ?>
					<a href="<?php echo $this->sequence_links['previous']['url']; ?>" accesskey=","><img src="http://www.utoronto.ca/atrc/stuff/atutor_icons/previous.gif" border="0" align="middle" alt="" class="relimg-prevnext" /> <?php echo $this->sequence_links['previous']['title']; ?></a>
				<?php elseif ($this->sequence_links['next']): ?>
					<a href="<?php echo $this->sequence_links['next']['url']; ?>" accesskey="."><?php echo $this->sequence_links['next']['title']; ?> <img src="http://www.utoronto.ca/atrc/stuff/atutor_icons/next.gif" border="0" align="middle" alt="" class="relimg-prevnext" /></a>
				<?php endif; ?>


			<?php endif; ?>
			<script type="text/javascript" language="javascript">
			//<![CDATA[
			var state = getcookie("side-menu");
			if (state && (state == 'none')) {
				showTocToggle("side-menu", "<?php echo _AT('show'); ?>","<?php echo _AT('hide'); ?>", "n", "show");
			} else {
				showTocToggle("side-menu", "<?php echo _AT('show'); ?>","<?php echo _AT('hide'); ?>", "n", "hide");
			}
			//showTocToggle("side-menu", "<?php echo _AT('show'); ?>","<?php echo _AT('hide'); ?>", "n")
			//]]>
			</script>
		</div>
	<?php endif; ?>
	<h2 class="page-title"><?php echo $this->page_title; ?></h2>

<a name="content"></a>
<?php global $msg; $msg->printAll(); ?>