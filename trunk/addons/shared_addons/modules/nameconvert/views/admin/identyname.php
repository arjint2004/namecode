<script>
$(function() {
	$('#aktifcekall').click(function () {    
		$(':checkbox.aktif').prop('checked', this.checked);    
	});
	$('#deletecekall').click(function () {    
		$(':checkbox.delete').prop('checked', this.checked);    
	});
	$('#btndell').click(function () {    
							$('form#identyname').append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
							$(".error-box").html("Deleting data").fadeIn("slow");   
							$.ajax({
								type: "POST",
								data: $('form#identyname').serialize(),
								url: $('form#identyname').attr('action'),
								beforeSend: function() {
									//$(obj).attr('onblur',"");
								},
								error	: function(){
									$(".error-box").css('background-color','rgba(255, 0, 0, 0.5)');
									$(".error-box").delay(1500).html('Fetching data failed. Try again.');
									$(".error-box").delay(1500).fadeOut("slow",function(){
										$(this).remove();
									});
																	
								},
								success: function(msg) {
									
									
									//$(obj).attr('onblur',"");
									$(".error-box").css('background-color','#4BB008');
									$(".error-box").delay(500).html('Delete data successed');
									$(".error-box").delay(500).fadeOut("slow",function(){
										$('#content-body').html(msg);
										$(this).remove();
									});	
								}
							});
							return false;
	});
	
	$('#ExpExcell').click(function () {    
		$('form#addpin').attr('action','<?=base_url()?>admin/ihs/export');
		$('form#addpin').attr('target', '__blank');  
		$('form#addpin').submit();
	});
	$('table#identyname tbody tr td a.delete').click(function () {   
									if(confirm('Are you sure?')){
									var ob=$(this);
										$.ajax({
											type: "POST",
											data: 'id_kat_indikator='+$('select#id_kat_indikator').val()+"&<?=$this->security->get_csrf_token_name();?>=<?=$this->security->get_csrf_hash();?>",
											url: $(this).attr('href'),
											beforeSend: function() {
											},
											error	: function(){							
											},
											success: function(msg) {
												$(ob).parent('td').parent('tr').remove();
											}
										});
									}
									return false;
	});
	
						$('div.pagination ul li a').click(function () { 
							$('form#identyname').append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
							$(".error-box").html("Fetching data").fadeIn("slow");   
							$.ajax({
								type: "POST",
								data: "id_kat_indikator="+$('select#id_kat_indikator').val()+"&<?=$this->security->get_csrf_token_name();?>=<?=$this->security->get_csrf_hash();?>",
								url: $(this).attr('href'),
								beforeSend: function() {
									//$(obj).attr('onblur',"");
								},
								error	: function(){
									$(".error-box").css('background-color','rgba(255, 0, 0, 0.5)');
									$(".error-box").delay(1500).html('Fetching data failed. Try again.');
									$(".error-box").delay(1500).fadeOut("slow",function(){
										$(this).remove();
									});
																	
								},
								success: function(msg) {
									
									
									//$(obj).attr('onblur',"");
									$(".error-box").css('background-color','#4BB008');
									$(".error-box").delay(500).html('Fetching data successed');
									$(".error-box").delay(500).fadeOut("slow",function(){
										$('#content-body').html(msg);
										$(this).remove();
									});	
								}
							});
							return false;
						});
});
</script>
<section class="title">
	<h4>Identifier Name</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="identyname"'); ?>
		
		<table class="zebra-striped">
			<tr>
				<th style="text-align:left;width:200px;">Choose Category Identifier :</th>
				<th style="text-align:left;">
					<select onchange="return submit();" style="width:200px;" id="id_kat_indikator" name="id_kat_indikator" required >
						<option value="">Select Category Identifier</option>
						<? foreach($identifirecat as $dataidentifirecat){?>
						<option <?if($dataidentifirecat['id']==@$_POST['id_kat_indikator']){echo 'selected';}if($dataidentifirecat['id']==@$_POST['id_group']){echo 'selected';}?> value="<?=$dataidentifirecat['id']?>"><?=$dataidentifirecat['kategori']?></option>
						<? } ?>
					</select>
				</th>
			</tr>
		</table>
		<br />
		<table class="zebra-striped" id="identyname">
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Edit</th>
				<th>Delete</th>
				<th style="width:50px;text-align:center"><input type="checkbox" name="idxall" value="1" id="deletecekall"/></th>
			</tr>
			<? 
			if(@$pagination['current_page']==0){@$pagination['current_page']=1;}
				$noq=(@$pagination['current_page']*@$pagination['per_page'])-@$pagination['per_page']+1;
			foreach($data as $datane){?>
			<tr>
				<td><?=$noq++?></td>
				<td><?=$datane['nama']?></td>
				<td><a class="edit modal" href="<?=base_url('admin/nameconvert/editidentyname/'.$datane['id'].'')?>">Edit</a></td>
				<td><a class="delete" href="<?=base_url('admin/nameconvert/deleteidentyname/'.$datane['id'].'')?>" >Delete</a></td>
				<td style="text-align:center;"><input type="checkbox" name="idx[<?=$datane['id']?>]" value="<?=$datane['id']?>" class="delete" /></td>
			</tr>
			<? } ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><input type="submit" name="delete" id="btndell" value="Delete" /></td>
			</tr>
		</table>
		<input type="hidden" name="page" id="paging" value="<?=$pagination['current_page']?>" />
		<?php echo form_close(); ?>
		<?php $this->load->view('admin/partials/pagination') ?>
	</div>
</section>