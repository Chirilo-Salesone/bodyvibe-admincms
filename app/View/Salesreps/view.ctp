<div class="row">
	<div class="col-md-12">


		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />
		
		<?php echo $this->Form->create('Salesrep',array('class'=>'admin-forms')); ?>

		<?php

			echo $this->Form->input('id',array('type'=>'hidden', 'disabled' => 'disabled'));
			echo $this->Form->input('name', array('disabled' => 'disabled'));
			echo $this->Form->input('email', array('disabled' => 'disabled'));
			echo $this->Form->input('country', array('type' => 'text', 'value' => $countries[ $this->request->data['Salesrep']['country_id'] ], 'disabled' => 'disabled' ));
			echo $this->Form->input('phone', array('disabled' => 'disabled'));
			echo $this->Form->input('phone_ext', array('disabled' => 'disabled'));

			$options = array('active'=>'Active','inactive'=>'Inactive');
			echo $this->Form->input('status',array('options'=>$options, 'disabled' => 'disabled'));

		?>

		<?php /*echo $this->Form->end(__('Submit'));*/ ?>
	</div>

</div>
