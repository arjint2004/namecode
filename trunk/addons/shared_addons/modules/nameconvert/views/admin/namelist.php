<script>
				$(document).ready(function(){
					
					$('input#ExportExcell').click(function () {    
						if($('select#id_groupnamelist').val()==''){
							$('select#id_groupnamelist').next('div#id_groupnamelist_chzn').children('a').css('border','1px solid rgba(255, 0, 0, 0.5)');
							return false;
						}else{
							$('select#id_groupnamelist').next('div#id_groupnamelist_chzn').children('a').css('border','1px solid #ccc');
						}
					});
					$('button#process').click(function () {    
							
							if($('select#id_groupnamelist').val()==''){
								$('select#id_groupnamelist').next('div#id_groupnamelist_chzn').children('a').css('border','1px solid rgba(255, 0, 0, 0.5)');
								return false;
							}else{
								$('select#id_groupnamelist').next('div#id_groupnamelist_chzn').children('a').css('border','1px solid #ccc');
							}
							
							$('table tr td#loadloop').append('<div class="containerloop"><div class="contentloop"><div class="circle"></div><div class="circle1"></div></div></div>');
							$.ajax({
								type: "POST",
								data: "process=1&id_group="+$('select#id_groupnamelist').val()+"&<?=$this->security->get_csrf_token_name();?>=<?=$this->security->get_csrf_hash();?>",
								url: '<?=base_url('admin/nameconvert/namelist')?>',
								beforeSend: function() {
									$('button#process').hide();
									$(".containerloop").attr('style',"display: block; top: 50%; width: 150px; position: absolute; left: 19%;");
									$(".containerloop").delay(1500000).fadeOut("slow",function(){
										$(this).remove();
									});
								},
								error	: function(){
									$('form#namelist').append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
									$(".error-box").css('background-color','rgba(255, 0, 0, 0.5)');
									$(".error-box").delay(1500000).html('Fetching data failed. Try again.');
									$(".error-box").delay(1500000).fadeOut("slow",function(){
										$(this).remove();
									});
																	
								},
								success: function(msg) {
									
									$('button#process').show();
									$('#content-body').html(msg);
									$(".containerloop").remove();
	
								}
							});
							
						return false;
					});
					
					$('#aktifcekall').click(function () {    
						$(':checkbox.aktif').prop('checked', this.checked);    
					});
					$('#deletecekallnmlist').click(function () {    
						$(':checkbox.delete').prop('checked', this.checked);    
					});
					$('#ExpExcell').click(function () {    
						$('form#addpin').attr('action','<?=base_url()?>admin/ihs/export');
						$('form#addpin').attr('target', '__blank');  
						$('form#addpin').submit();
					});
					$('a.viewdetail').click(function () {
						$('#cboxContent').html($('div#'+$(this).attr('modal')).html());
					});
					$('div.pagination ul li a').click(function () { 
							$('form#namelist').append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
							$(".error-box").html("Fetching data").fadeIn("slow");   
							$.ajax({
								type: "POST",
								data: "id_group="+$('select#id_groupnamelist').val()+"&<?=$this->security->get_csrf_token_name();?>=<?=$this->security->get_csrf_hash();?>",
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
									$(".error-box").delay(800).html('Fetching data successed');
									$(".error-box").delay(800).fadeOut("slow",function(){
										$('#content-body').html(msg);
										$(this).remove();
									});	
								}
							});
							return false;
						});
				});
				function update(obj){
					var value=$(obj).val();
					var id_group=$(obj).attr('id_group');
					$(obj).after("<div class=\"error-box\" style='display: block; position: absolute; background-color: rgb(75, 176, 8); top: 0px; left: 0px; width: 224px; opacity: 1;'></div>");
					$(".error-box").html("Sending data").fadeIn("slow");
					$.ajax({
							type: "POST",
							data: "simpan=single&id_group="+id_group+"&nama="+value+'&<?=$this->security->get_csrf_token_name();?>=<?=$this->security->get_csrf_hash();?>',
							url: '<?=base_url()?>admin/nameconvert/namelist',
							beforeSend: function() {
								//$(obj).attr('onblur',"");
							},
							error	: function(){
								$(".error-box").css('background-color','rgba(255, 0, 0, 0.5)');
								$(".error-box").delay(1500).html('Send data failed. Try again.');
								$(".error-box").delay(1500).fadeOut("slow",function(){
									$(this).remove();
								});
																
							},
							success: function(msg) {
								
								//$(obj).attr('onblur',"");
								$(".error-box").css('background-color','#4BB008');
								$(".error-box").delay(300).html('Send data successed');
								$(".error-box").delay(200).fadeOut("slow",function(){
									$(this).remove();
								});	
							}
					});
				}
				function editfield(obj,id_jurusan,field){
					var value=$(obj).val();
					//var childval=$(obj).children('input[type["text"]]').attr('type');
					//if(childval!='text'){
						//$(obj).html('<input maxlength="100" field="'+field+'" size="1" id="'+value+''+id_jurusan+'" idjur="'+id_jurusan+'" class="editintd"   onblur="update(this)" type="text" value="'+value+'" name="edit['+id_jurusan+']" />');	
						$(obj).val(value);
						$(obj).attr('field',field);
						$(obj).attr('id',''+value+''+id_jurusan+'');
						$(obj).attr('idjur',id_jurusan);
						//$(obj).attr('onblur',"update(this)");
						$(obj).attr('name','edit['+id_jurusan+']');
						$(obj).prop( "disabled", false );
						$('#'+value+''+id_jurusan+'').select();
					//}
					
					$(obj).focus();				

				}
</script>

<section class="title">
	<h4>Name List</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="namelist"'); 
		if(!empty($data)){
		?>
		<input type="hidden" name="id" required value="<?=@$data[0]['id']?>"/>
		<? } ?>
		
		<table style="width:100% ; margin:20px 0;">
			<tbody>
				<tr>
					<td  style="width:200px ;">
						<select onchange="return submit();" style="width:200px;" name="id_group" id="id_groupnamelist"  >
						<option value="">Select Region</option>
						<? foreach($groupname as $datagroupname){?>
						<option <?if($datagroupname['id']==@$_POST['id_group']){echo 'selected';}?> value="<?=$datagroupname['id']?>"><?=$datagroupname['group']?></option>
						<? } ?>
						</select>
					</td>
					<td id="loadloop" style="width:80px;">
						<div class="buttons" style="text-align:left;margin:0;">		
							<button class="btn green" style="margin:0;" value="Process" id="process" name="process" type="submit">
								<span>Process</span>
							</button>
						</div>
					</td>
					<td>
						<div class="buttons" style="text-align:left;margin:0;">		
							<input type="submit" class="btn grey" style="margin:0; padding:7px;" id="ExportExcell" name="ExportExcell" value="ExportExcell" />
							<input type="submit" class="btn grey" style="margin:0; padding:7px;" id="ExportExcell" name="ExportExcellUnknown" value="ExportExcell Unknown Result" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		
		<table>
			<tr>
				<th>NO</th>
				<th>NAME</th>
				<th>BORN PLACE</th>
				<th>BORN DATE</th>
				<th>RELIGION</th>
				<th>LAST EDUCATION</th>
				<!--<th>EMPLOYMENT</th>
				<th>MOTHER'S NAME</th>
				<th>FATHER'S NAME</th>-->
				<th>RESULT</th>
				<th>CONCULSION</th>
				<th>ACTION</th>
				<th><input type="checkbox" name="idxall" value="1" id="deletecekallnmlist"/></th>
			</tr>
			<? 
			if(@$pagination['current_page']==0){@$pagination['current_page']=1;}
				$noq=(@$pagination['current_page']*@$pagination['per_page'])-@$pagination['per_page']+1;
			foreach($name as $datane){?>
			<tr> 	 	 	 	 	 
				<td><?=$noq++?></td>
				<td><?=$datane['name']?></td>
				<td><?=$datane['born_place']?></td>
				<td><?=$datane['born_date']?></td>
				<td><?=$datane['religion']?></td>
				<td><?=$datane['last_education']?></td>
				<!--<td><?=$datane['employment']?></td>
				<td><?=$datane['mother']?></td>
				<td><?=$datane['father']?></td>-->
				<td>
				<a class="viewdetail modal" modal="modal<?=$datane['id']?>" style="cursor:pointer;">View Result</a>
				<div style="display:none;" id="modal<?=$datane['id']?>">
					
					<section class="title">
						<h4>Result</h4>
					</section>
					<section class="item">
						<div class="content">
							<? pr(unserialize($datane['result']))?>
						</div>
					</section>
				</div>
				</td>
				<td><?=$datane['kesimpulan']?></td>
				<td><a class="modal" href="<?=base_url('admin/nameconvert/editnamelist/'.$datane['id'].'')?>">Edit</a></td>
				<td><input type="checkbox" name="idx[<?=$datane['id']?>]" value="<?=$datane['id']?>" class="delete" /></td>
			</tr>
			<? } ?>
		</table>
		<div class="buttons" style="text-align:right;clear:both;">		
			<button class="btn red" value="delete" name="delete" type="submit">
				<span>Delete</span>
			</button>
		</div>
		
		<?php echo form_close(); ?>
		<?php $this->load->view('admin/partials/pagination') ?>
	</div>
</section>