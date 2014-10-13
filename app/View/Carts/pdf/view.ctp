<div class="row">
	<div class="col-md-12">
	<?php echo $this->Form->create('Color',array('class'=>'admin-forms')); ?>

		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('code');
			echo $this->Form->input('name');
			echo $this->Form->input('status',array('options'=>array("1"=>'Active',"0"=>'Inactive')));
		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>

</div>
