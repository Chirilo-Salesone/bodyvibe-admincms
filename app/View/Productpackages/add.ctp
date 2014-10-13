<div class="products form">
<?php echo $this->Form->create('Product'); ?>
	<fieldset>
		<legend><?php echo __('Add Product'); ?></legend>
	<?php
		echo $this->Form->input('image_name');
		echo $this->Form->input('brand_id');
		echo $this->Form->input('description');
		echo $this->Form->input('number');
		echo $this->Form->input('emailer_link');
		echo $this->Form->input('sizeInc');
		echo $this->Form->input('sizeMm');
		echo $this->Form->input('identification');
		echo $this->Form->input('color_id');
		echo $this->Form->input('price');
		echo $this->Form->input('promocode');
		echo $this->Form->input('discount_value');
		echo $this->Form->input('discount_chart');
		echo $this->Form->input('package_deal');
		echo $this->Form->input('view_by_piece');
		echo $this->Form->input('view_by_pack');
		echo $this->Form->input('prod_weight');
		echo $this->Form->input('prod_gemSize');
		echo $this->Form->input('prod_width');
		echo $this->Form->input('status');
		echo $this->Form->input('date_added');
		echo $this->Form->input('rank');
		echo $this->Form->input('db_name');
		echo $this->Form->input('new_styles');
		echo $this->Form->input('generate_email');
		echo $this->Form->input('avail_qty');
		echo $this->Form->input('packaging');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Products'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Brands'), array('controller' => 'brands', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Brand'), array('controller' => 'brands', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors'), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color'), array('controller' => 'colors', 'action' => 'add')); ?> </li>
	</ul>
</div>
