<div class="row">
	<div class="col-md-12">


		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />

		<?php echo $this->Form->create('Salesrep',array('class'=>'admin-forms')); ?>

		<?php

			echo $this->Form->input('id',array('type'=>'hidden'));
			echo $this->Form->input('name');
			echo $this->Form->input('email');
			echo $this->Form->input('country');
			echo $this->Form->input('phone');
			echo $this->Form->input('phone_ext');

			$options = array('active'=>'Active','inactive'=>'Inactive');
			echo $this->Form->input('status',array('options'=>$options));

		?>

		<?php echo $this->Form->end(__('Submit')); ?>
	</div>

</div>
