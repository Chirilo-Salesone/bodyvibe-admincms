<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />
		<?php
			$options = array('active'=>'Active','inactive'=>'Inactive');
		?>

		<?php echo $this->Form->create('Bodypart',array('class'=>'admin-forms')); ?>
		<?php
			echo $this->Form->input('name');
			echo $this->Form->input('valueurl');
			echo $this->Form->input('status', array('options'=> $options ));
			
		?>
		
		<?php echo $this->Form->end('Submit'); ?>		

	</div>	

</div>
