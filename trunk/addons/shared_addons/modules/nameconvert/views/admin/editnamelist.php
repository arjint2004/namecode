<script>
				$(document).ready(function(){
					$("#datepicker, .datepicker").datepicker({dateFormat: 'dd-mm-yy'});
					$('div#id_id_groupnamelistedit_chzn').remove();
					$('select#id_groupnamelist').chosen();
					$('form#editnamelist').validate();
				});
</script>
<section class="title">
	<h4>Name Edit</h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud" id="editnamelist"'); 
		if(!empty($data)){
		?>
		<input type="hidden" name="id" required value="<?=@$data[0]['id']?>"/>
		<? } ?>
		<table class="zebra-striped">
			<tr>
				<td>GROUP</td>
				<td>
					<select style="width:200px;" name="id_group" id="id_groupnamelistedit" required >
						<option value="">Select Group Name</option>
						<? foreach($group as $datagroupname){?>
						<option <?if($datagroupname['id']==@$data[0]['id_group']){echo 'selected';}?> value="<?=$datagroupname['id']?>"><?=$datagroupname['group']?></option>
						<? } ?>
					</select>
				</td>
			</tr> 	 	 	 	 	 	 
			<tr>
				<td>name</td>
				<td><input type="text" name="name" required value="<?=@$data[0]['name']?>"/></td>
			</tr>
			<tr>
				<td>born_place</td>
				<td><input type="text" name="born_place"  value="<?=@$data[0]['born_place']?>"/></td>
			</tr>
			<tr>
				<td>born_date</td>
				<td><input type="text" name="born_date" class="datepicker" id="datepicker"  value="<?=@$data[0]['born_date']?>"/></td>
			</tr>
			<tr>
				<td>religion</td>
				<td><input type="text" name="religion"  value="<?=@$data[0]['religion']?>"/></td>
			</tr>
			<tr>
				<td>last_education</td>
				<td><input type="text" name="last_education"  value="<?=@$data[0]['last_education']?>"/></td>
			</tr>
			<tr>
				<td>employment</td>
				<td><input type="text" name="employment"  value="<?=@$data[0]['employment']?>"/></td>
			</tr>
			<tr>
				<td>mother</td>
				<td><input type="text" name="mother"  value="<?=@$data[0]['mother']?>"/></td>
			</tr>
			<tr>
				<td>father</td>
				<td><input type="text" name="father"  value="<?=@$data[0]['father']?>"/></td>
			</tr>
			<tr>
				<td>active</td>
				<td><input type="hidden" name="active"  value="1" checked /><input type="checkbox" name="active"  value="<?=@$data[0]['active']?>" checked /></td>
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