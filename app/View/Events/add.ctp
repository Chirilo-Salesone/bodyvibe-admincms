<div class="row">
	<div class="col-md-12">

	<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
	</a>			

	<hr/>

	<?php 

		echo $this->Form->create('Event',array('class'=>'admin-forms'));
		echo $this->Form->input('showname',array('label'=>'Show Name'));
		echo $this->Form->input('schedule');
		echo $this->Form->input('booth_no',array('style'=>'width: 10%'));;

		echo $this->Form->input('country',array('style'=>'width: 25%'));
		echo $this->Form->input('city');
			
	 	echo $this->Form->end('Submit'); 

	?>

	</div>

</div>

