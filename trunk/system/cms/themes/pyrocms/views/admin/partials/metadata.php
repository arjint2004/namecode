<?php
Asset::js('jquery/jquery.js');
Asset::js_inline('jQuery.noConflict();');
Asset::js('jquery/jquery-ui.min.js', 'jquery/jquery-ui.min.js');
Asset::js('jquery/jquery.colorbox.js');
Asset::js('jquery/jquery.cooki.js');
Asset::js('jquery/jquery.slugify.js');

Asset::js(array('codemirror/codemirror.js',
	'codemirror/mode/css/css.js',
	'codemirror/mode/htmlmixed/htmlmixed.js',
	'codemirror/mode/javascript/javascript.js',
	'codemirror/mode/markdown/markdown.js',
	'plugins.js',
	'scripts.js'
)); ?>

<?php if (isset($analytic_visits) OR isset($analytic_views)): ?>
	<?php Asset::js('jquery/jquery.excanvas.min.js'); ?>
	<?php Asset::js('jquery/jquery.flot.js'); ?>
<?php endif; ?>

<script type="text/javascript">
	pyro = { 'lang' : {} };
	var APPPATH_URI					= "<?php echo APPPATH_URI;?>";
	var SITE_URL					= "<?php echo rtrim(site_url(), '/').'/';?>";
	var BASE_URL					= "<?php echo BASE_URL;?>";
	var BASE_URI					= "<?php echo BASE_URI;?>";
	var UPLOAD_PATH					= "<?php echo UPLOAD_PATH;?>";
	var DEFAULT_TITLE				= "<?php echo addslashes($this->settings->site_name); ?>";
	pyro.admin_theme_url			= "<?php echo BASE_URL . $this->admin_theme->path; ?>";
	pyro.apppath_uri				= "<?php echo APPPATH_URI; ?>";
	pyro.base_uri					= "<?php echo BASE_URI; ?>";
	pyro.lang.remove				= "<?php echo lang('global:remove'); ?>";
	pyro.lang.dialog_message 		= "<?php echo lang('global:dialog:delete_message'); ?>";
	pyro.csrf_cookie_name			= "<?php echo config_item('cookie_prefix').config_item('csrf_cookie_name'); ?>";
</script>

<?php Asset::css(array('plugins.css','loopload.css', 'jquery/colorbox.css', 'codemirror.css', 'animate/animate.css')); ?>

<?php echo Asset::render(); ?>

<!--[if lt IE 9]>
<?php echo Asset::css('ie8.css', null, 'ie8'); ?>
<?php echo Asset::render_css('ie8'); ?>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php if ($module_details['sections']): ?>
<style>section#content {margin-top: 170px!important;}</style>
<?php endif; ?>

<?php echo $template['metadata']; ?>
		<script src="<?=base_url('/system/cms/themes/pyrocms/js/jquery.validate.js')?>"></script>
        <script src="<?=base_url('/system/cms/themes/pyrocms/js/localization/messages_id.js')?>"></script>
		<script>
		$.fn.scrollintoview = function(options){
			//setting default value jika parameter tidak dilewatkan
			var    defaults = {
			speed:'1100'
			},
			settings = $.extend({}, defaults, options);
			var element = this;  //"this" adalah DOM object
			
			$('html, body').animate({
				scrollTop: $(element).offset().top
			}, parseInt(settings.speed));
			return false;
		};
	</script>
	
	<script>
	function toggle(id) {
		var el = document.getElementById(id);
		var img = document.getElementById("arrow");
		var box = el.getAttribute("class");
		if(box == "hidemenu"){
			el.setAttribute("class", "show");
			delay(img, "<?=base_url('/system/cms/themes/pyrocms/img/arrow-right.png')?>", 400);
		}
		else{
			el.setAttribute("class", "hidemenu");
			delay(img, "<?=base_url('/system/cms/themes/pyrocms/img/arrow-left.png')?>", 400);
		}
	}

	function delay(elem, src, delayTime){
		window.setTimeout(function() {elem.setAttribute("src", src);}, delayTime);
	}
	$(function() {
		$( "div#menubox #deco div.bt a" ).click(function() {
			var obt=$(this).next('ul');
			$(obt).toggle( "slow", function() {
				// Animation complete.
			});
		});
	});
	</script>