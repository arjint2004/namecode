<script>
$(function() {
	$('form#importidentyfier').validate();
});
</script>

<section class="title">
	<h4>Import Identifier Name</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="importidentyfier"'); ?>
		<table class="zebra-striped">
			<tr>
				<td width="10%">Category</td>
				<td>
					<select style="width:200px;" name="id_kat_indikator" required >
						<option value="">Select Category Identifier</option>
						<? foreach($identifirecat as $dataidentifirecat){?>
						<option value="<?=$dataidentifirecat['id']?>"><?=$dataidentifirecat['kategori']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="10%">File Excell</td>
				<td><input type="file" required  size="15" id="file_browse" name="file_excell"></td>
			</tr>
		</table>
		<div class="buttons">		
			<button class="btn blue" value="save" name="btnAction" type="submit">
				<span>Save</span>
			</button>						
			<a class="btn gray cancel" href="<?=base_url('admin/nameconvert/identyname');?>">Cancel</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</section>