<div class="row">
	<div class="col-md-12">


	<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
		<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
	</a>
	<br />
	<br />


	<?php echo $this->Form->create('SubCategory',array('class'=>'admin-forms')); ?>

		<?php
		
			$optionArr = array('active'=>'Active','inactive'=>'Inactive');

			echo $this->Form->input('id', array('disabled' => 'disabled'));
			echo $this->Form->input('name', array('disabled' => 'disabled'));
			echo $this->Form->input('description', array('disabled' => 'disabled'));
			echo $this->Form->input('category_id', array('options'=>$categories, 'disabled' => 'disabled'));
			echo $this->Form->input('valueurl', array('disabled' => 'disabled'));
			echo $this->Form->input('status',array('options'=>$optionArr, 'disabled' => 'disabled'));

		?>
	    
	    <?php /*echo $this->Form->end('Submit');*/ ?>

	</div>

</div>
