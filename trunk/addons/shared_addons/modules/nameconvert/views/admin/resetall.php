<section class="title">
	<h4>Reset All Data</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<table class="zebra-striped">
			<tr>
				<td>Password</td>
				<td><input type="text" name="pass" required value="<?=@$data[0]['kategori']?>"/></td>
			</tr>
		</table>
		<div class="buttons">		
			<button class="btn blue" value="save" name="btnAction" type="submit">
				<span>Reset</span>
			</button>						
		<a class="btn gray cancel" href="<?=base_url('admin/nameconvert/namelist');?>">Cancel</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</section>