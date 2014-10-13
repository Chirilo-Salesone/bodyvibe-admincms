<div class="countries form">
<?php echo $this->Form->create('Country'); ?>
	<fieldset>
		<legend><?php echo __('Add Country'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code_2');
		echo $this->Form->input('code_3');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Countries'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Salesreps'), array('controller' => 'salesreps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Salesrep'), array('controller' => 'salesreps', 'action' => 'add')); ?> </li>
	</ul>
</div>
