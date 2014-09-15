<section class="title">
	<h4>Import Name Group</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<table class="zebra-striped">
			<tr>
				<td width="10%">File Excell</td>
				<td><input type="file"  size="15" id="file_browse" name="file_excell"></td>
			</tr>
		</table>
		<div class="buttons">		
			<button class="btn blue" value="save" name="btnAction" type="submit">
				<span>Save</span>
			</button>						
			<a class="btn gray cancel" href="<?=base_url('admin/nameconvert/identycategory');?>">Cancel</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</section>