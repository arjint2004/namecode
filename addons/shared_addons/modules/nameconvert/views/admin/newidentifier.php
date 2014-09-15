<script>
$(function() {
	$('form#identifirecat').validate();
});
</script>
<section class="title">
	<h4>New Identifier</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="identifirecat"'); 
		if(!empty($data)){
		?>
		<input type="hidden" name="id" required value="<?=@$data[0]['id']?>"/>
		<? } ?>

		
		<table class="zebra-striped">
			<tr>
				<th style="text-align:left;width:200px;">Choose Category Identifier :</th>
				<th style="text-align:left;">
					<select style="width:200px;" name="id_kat_indikator" required >
						<option value="">Select Category Identifier</option>
						<? foreach($identifirecat as $dataidentifirecat){?>
						<option value="<?=$dataidentifirecat['id']?>"><?=$dataidentifirecat['kategori']?></option>
						<? } ?>
					</select>
				</th>
			</tr>
		</table>
		<br />
		<ul class="namelist no_number">
			<? for($i=1;$i<=50;$i++){?>
			<li><input type="text" name="nama[<?=$i?>]" id_group="<?=$i?>" placeholder="Fill Name"/></li>
			<? } ?>
		</ul>
		<br style="clear:both;" />
		<br />
		<div class="buttons" style="text-align:center;">		
			<button class="btn blue" value="save" name="btnAction" type="submit">
				<span>Save</span>
			</button>						
		<a class="btn gray cancel" href="<?=base_url('admin/nameconvert/identycategory');?>">Cancel</a>
		</div>
		<?php echo form_close(); ?>
	</div>
</section>