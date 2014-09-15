<section class="title">
	<h4>Identifier Name Edit</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); 
		if(!empty($data)){
		?>
		<input type="hidden" name="id" required value="<?=@$data[0]['id']?>"/>
		<? } ?>
		<table class="zebra-striped">
			<tr>
				<td>Category</td>
				<td>
					<select style="width:200px;" name="id_kat_indikator" required >
						<option value="">Select Category Identifier</option>
						<? foreach($identifirecat as $dataidentifirecat){?>
						<option <? if(@$data[0]['id_kat_indikator']==$dataidentifirecat['id']){echo 'selected';}?> value="<?=$dataidentifirecat['id']?>"><?=$dataidentifirecat['kategori']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type="text" name="nama" required value="<?=@$data[0]['nama']?>"/></td>
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