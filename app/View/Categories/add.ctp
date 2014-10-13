<!-- <div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('group_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?></li>
	</ul>
</div>
 -->

<div class="row">
	<?php
		$status = array('active'=>'Active','inactive'=>'Inactive');
	?>
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />

		<?php echo $this->Form->create('Category',array('class'=>'admin-forms')); ?>

			<?php
				echo $this->Form->input('name');
				echo $this->Form->input('description');
				echo $this->Form->input('group_id');
				echo $this->Form->input('categoryurl');
				echo $this->Form->input('status', array('options'=> $status));
			?>
		<?php echo $this->Form->end('Submit'); ?>

	</div>

</div>