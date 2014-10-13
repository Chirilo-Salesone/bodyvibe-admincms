<div class="row">
	<div class="col-md-12">
	<?php echo $this->Form->create('Catalog',array('class'=>'admin-forms')); ?>

		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('imgsrc',array('label'=>'Image Source'));
			echo $this->Form->input('filesrc',array('label'=>'File Source'));
			echo $this->Form->input('name');
			echo $this->Form->input('status',array('options'=>array("active"=>'Active',"inactive"=>'Inactive')));
			
		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>

</div>
