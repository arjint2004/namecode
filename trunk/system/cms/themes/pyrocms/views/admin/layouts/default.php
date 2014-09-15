<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->

<head>
	<meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>

	<base href="<?php echo base_url(); ?>" />

	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- CSS. No need to specify the media attribute unless specifically targeting a media type, leaving blank implies media=all -->
	<?php echo Asset::css('plugins.css'); ?>
	<?php echo Asset::css('workless/workless.css'); ?>
	<?php echo Asset::css('workless/application.css'); ?>
	<?php echo Asset::css('workless/responsive.css'); ?>
        <?php
        $vars = $this->load->_ci_cached_vars;
        if ($vars['lang']['direction']=='rtl'){
            echo Asset::css('workless/rtl/rtl.css');
        }
        ?>
	<!-- End CSS-->

	<!-- Load up some favicons -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-precomposed.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-114x114-precomposed.png">
	<?php echo Asset::css('menu.css'); ?>
	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

</head>

<body>

	<div id="container">

<? if($this->_ci_cached_vars['module_details']['slug']!='nameconvert'){?>
<style>

 #container {
    width: 100%;
 }
 section#content {
  float: right;
  width: 84%;
  margin: 130px 1% 150px !important;
}
div#menubox #box {
  top: 128px;
}
</style>
<?}else{?>
<style>

 #container {
    width: 100%;
 }
 section#content {
  float: right;
  width: 84%;
  margin: 95px 1% 150px !important;
}
</style>
<? } ?>

<div id="menubox">
<div id="box" class="hidemenu">
    <!--<ul id="tab">
        <li>
            <img id="arrow" onclick="toggle('box');" src="<?=base_url('/system/cms/themes/pyrocms/img/arrow-left.png')?>">
        </li>
    </ul>-->
    <div id="links">
        <div id="deco">
            <div class="bt"><a >Identifier Category</a>
				<ul>
					<li><a href="<?=base_url('admin/nameconvert/identycategory')?>">Identifier Category List</a></li>
					<li><a href="<?=base_url('admin/nameconvert/newcategory')?>">New Identifier Category</a></li>
					<li><a href="<?=base_url('admin/nameconvert/importcategory')?>">Import Identifier Category</a></li>
				</ul>
			</div>
            <div class="bt"><a >Identifier</a>
				<ul>
					<li><a href="<?=base_url('admin/nameconvert/identyname')?>">Identifier Name</a></li>
					<li><a href="<?=base_url('admin/nameconvert/newidentifier')?>">New Identifier</a></li>
					<li><a href="<?=base_url('admin/nameconvert/importidentifier')?>">Import Identifier</a></li>
				</ul>
			</div>
            <div class="bt"><a >Name Group</a>
				<ul>
					<li><a href="<?=base_url('admin/nameconvert/namegroup')?>">Name Group</a></li>
					<li><a href="<?=base_url('admin/nameconvert/newnamegroup')?>">New Name Group</a></li>
					<li><a href="<?=base_url('admin/nameconvert/importnamegroup')?>">Import Name Group</a></li>
				</ul>
			</div>
            <div class="bt"><a >Name List</a>
				<ul>
					<li><a href="<?=base_url('admin/nameconvert/namelist')?>">Name List</a></li>
					<li><a href="<?=base_url('admin/nameconvert/newname')?>">New Name</a></li>
					<li><a href="<?=base_url('admin/nameconvert/importname')?>">Import Name</a></li>
				</ul>
			</div>
            <div class="bt"><a >Processing</a>
				<ul>
					<li><a href="<?=base_url('admin/nameconvert/importexcell')?>">Import Excell</a></li>
					<li><a href="<?=base_url('admin/nameconvert/exportexcell')?>">Export Excell</a></li>
					<li><a href="<?=base_url('admin/nameconvert/statistic')?>">Statistic</a></li>
					<li><a href="<?=base_url('admin/nameconvert/quickprocess')?>">Quick Process</a></li>
				</ul>
			</div>
        </div>
    </div>
</div>
		<section id="content">
			
			<header class="hide-on-ckeditor-maximize">
			<?php file_partial('header'); ?>
			</header>

			<div id="content-body">
				<?php file_partial('notices'); ?>
				<?php echo $template['body']; ?>
			</div>

		</section>

	</div>

	<footer class="clearfix">
		<div class="wrapper">
			<p class="credits">Copyright &copy;<?php echo date('Y'); ?> PyroCMS LLC &nbsp; <span>Version <?php echo CMS_VERSION.' '.CMS_EDITION; ?> &nbsp; Rendered in {elapsed_time} sec. using {memory_usage}.</span></p>

			<ul id="lang">
				<form action="<?php echo current_url(); ?>" id="change_language" method="get">
					<select class="chzn" name="lang" onchange="this.form.submit();">
						<?php foreach(config_item('supported_languages') as $key => $lang): ?>
							<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? ' selected="selected" ' : ''; ?>>
								 <?php echo $lang['name']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</form>
			</ul>
		</div>
	</footer>

	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6. chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>