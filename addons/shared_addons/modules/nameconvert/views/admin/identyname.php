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
	<h4>Identifier Name</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="addpin"'); ?>
		
		<table class="zebra-striped">
			<tr>
				<th style="text-align:left;width:200px;">Choose Category Identifier :</th>
				<th style="text-align:left;">
					<select onchange="return submit();" style="width:200px;" name="id_kat_indikator" required >
						<option value="">Select Category Identifier</option>
						<? foreach($identifirecat as $dataidentifirecat){?>
						<option <?if($dataidentifirecat['id']==@$_POST['id_kat_indikator']){echo 'selected';}?> value="<?=$dataidentifirecat['id']?>"><?=$dataidentifirecat['kategori']?></option>
						<? } ?>
					</select>
				</th>
			</tr>
		</table>
		<br />
		<table class="zebra-striped">
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Edit</th>
				<th>Delete</th>
				<th style="width:50px;text-align:center"><input type="checkbox" name="idxall" value="1" id="deletecekall"/></th>
			</tr>
			<? 
			$no=1;
			foreach($data as $datane){?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$datane['nama']?></td>
				<td><a href="<?=base_url('admin/nameconvert/editidentyname/'.$datane['id'].'')?>">Edit</a></td>
				<td><a href="<?=base_url('admin/nameconvert/deleteidentyname/'.$datane['id'].'')?>" onclick="if(!confirm('Are you sure?')){return false;}">Delete</a></td>
				<td style="text-align:center;"><input type="checkbox" name="idx[<?=$datane['id']?>]" value="<?=$datane['id']?>" class="delete" /></td>
			</tr>
			<? } ?>
			<tr>
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