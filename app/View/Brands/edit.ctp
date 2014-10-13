<div class="row">

	<div class="col-md-12">
	<?php echo $this->Form->create('Brand',array('class'=>'admin-forms')); ?>

		<?php
			echo $this->Form->input('id',array('type'=>'hidden'));
			echo $this->Form->input('name');
			echo $this->Form->input('short_name');
			echo $this->Form->input('display_type');
			echo $this->Form->input('seq_no');
			echo $this->Form->input('url');
		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>	

</div>	

