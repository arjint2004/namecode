
<script>
$(function() {
	$('form#identynameformedit').submit(function () {   
							$('form#identynameformedit').append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
							$(".error-box").html("Editing data").fadeIn("slow");   
							$.ajax({
								type: "POST",
								data: $('form#identynameformedit').serialize(),
								url: $('form#identynameformedit').attr('action'),
								beforeSend: function() {
									//$(obj).attr('onblur',"");
								},
								error	: function(){
									$(".error-box").css('background-color','rgba(255, 0, 0, 0.5)');
									$(".error-box").delay(1500).html('Editing data failed. Try again.');
									$(".error-box").delay(1500).fadeOut("slow",function(){
										$(this).remove();
									});
																	
								},
								success: function(msg) {
									
									
									//$(obj).attr('onblur',"");
									$(".error-box").css('background-color','#4BB008');
									$(".error-box").delay(500).html('Editing data successed');
									$(".error-box").delay(500).fadeOut("slow",function(){
										$(this).remove();
										jQuery.colorbox.close("Edit succesfully");
										$.ajax({
											type: "POST",
											data: 'id_kat_indikator='+$('select#id_kat_indikator').val()+"&<?=$this->security->get_csrf_token_name();?>=<?=$this->security->get_csrf_hash();?>",
											url: '<?=base_url('admin/nameconvert/identyname/')?>/'+$('input#paging').val(),
											beforeSend: function() {
											},
											error	: function(){

																				
											},
											success: function(msg) {
												$('#content-body').html(msg);
											}
										});
									});	
								}
							});
							return false;
	});
});
</script>
<section class="title">
	<h4>Identifier Name Edit</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="identynameformedit"'); 
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