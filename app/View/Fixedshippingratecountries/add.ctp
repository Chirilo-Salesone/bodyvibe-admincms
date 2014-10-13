<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />

		<?php echo $this->Form->create('Fixedshippingratecountry',array('class'=>'admin-forms')); ?>
		<?php
			echo $this->Form->input('country_id', array('options'=>$countries));
			echo $this->Form->input('rate', array('type'=>'text'));
			
		?>
		
		<?php echo $this->Form->end('Submit'); ?>		

	</div>	

</div>
