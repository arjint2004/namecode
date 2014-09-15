<section class="title">
	<h4><?if(!empty($data)){?>Edit <?}else{?>New <?}?> Identifier Category</h4>
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
				<td>Category Name</td>
				<td><input type="text" name="kategori" required value="<?=@$data[0]['kategori']?>"/></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><textarea name="keterangan" required ><?=@$data[0]['keterangan']?></textarea></td>
			</tr>
			
			<tr>
				<td>Active</td>
				<td>
				<input type="hidden" name="active"  value="0" />
				<input type="checkbox" name="active" <?if(@$data[0]['active']==1){echo 'checked';}?> value="1" />
				</td>
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