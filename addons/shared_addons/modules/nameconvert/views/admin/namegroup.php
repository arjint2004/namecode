<script>
$(function() {
	$('#aktifcekall').click(function () {    
		$(':checkbox.aktif').prop('checked', this.checked);    
	});
	$('#deletecekall').click(function () {    
		$(':checkbox.delete').prop('checked', this.checked);    
	});
	$('#ExpExcell').click(function () {    
		$('form#addpin').attr('action','<?=base_url()?>admin/ihs/export');
		$('form#addpin').attr('target', '__blank');  
		$('form#addpin').submit();
	});
});
</script>
<section class="title">
	<h4>Name Group</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="addpin"'); ?>
		<table class="zebra-striped">
			<tr>
				<th>No</th>
				<th>Group</th>
				<th>Description</th>
				<th>Action</th>
				<th>Edit</th>
				<th>Delete</th>
				<th><input type="checkbox" name="idxall" value="1" id="deletecekall"/></th>
			</tr>
			<? 
			$no=1;
			foreach($data as $datane){?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$datane['group']?></td>
				<td><?=$datane['keterangan']?></td>
				<td>
				<?
				if($datane['active']==0){
				?>
					<a href="<?=base_url('admin/nameconvert/activatenamegroup/'.$datane['id'].'/1')?>">Activate</a>
				<?}else{?>
					<a href="<?=base_url('admin/nameconvert/activatenamegroup/'.$datane['id'].'/0')?>">Deactivate</a>
				<? } ?>
				</td>
				<td><a href="<?=base_url('admin/nameconvert/editnamegroup/'.$datane['id'].'')?>">Edit</a></td>
				<td><a href="<?=base_url('admin/nameconvert/deletenamegroup/'.$datane['id'].'')?>" onclick="if(!confirm('Are you sure?')){return false;}">Delete</a></td>
				<td><input type="checkbox" name="idx[<?=$datane['id']?>]" value="<?=$datane['id']?>" class="delete" /></td>
			</tr>
			<? } ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><input type="submit" name="delete" value="Delete" /></td>
			</tr>
		</table>
		<?php echo form_close(); ?>
		<?php $this->load->view('admin/partials/pagination') ?>
	</div>
</section>