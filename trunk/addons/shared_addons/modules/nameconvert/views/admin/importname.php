<script>
$(document).ready(function(){
	$('form#formimportname').validate();
});
</script>
<section class="title">
	<h4>Import Name</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="formimportname"'); ?>
		
		<table class="zebra-striped">
			<tr>
				<td width="10%">Region</td>
				<td>
					<select name="id_group" required >
						<option value="">Pilih  Region</option>
						<? foreach($group as $datagroup){?>
						<option value="<?=$datagroup['id']?>"><?=$datagroup['group']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="10%">File Excell</td>
				<td><input type="file"  size="15" id="file_browse" name="file_excell" required></td>
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