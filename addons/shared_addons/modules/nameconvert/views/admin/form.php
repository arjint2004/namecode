<section class="title">
	<!-- We'll use $this->method to switch between nameconvert.create & nameconvert.edit -->
	<h4><?php echo lang('nameconvert:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('nameconvert:name'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', set_value('name', $nameconvert->name), 'class="width-15"'); ?></div>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo lang('nameconvert:slug'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', set_value('slug', $nameconvert->slug), 'class="width-15"'); ?></div>
			</li>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>
