<div class="designs form">
<?php echo $this->Form->create('Design'); ?>
	<fieldset>
		<legend><?php echo __('Add Design'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('desc');
		echo $this->Form->input('status');
		echo $this->Form->input('date_added');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Designs'), array('action' => 'index')); ?></li>
	</ul>
</div>
