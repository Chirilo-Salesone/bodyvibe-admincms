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
		<?php echo $this->Form->create('CategoryGroup',array('class'=>'admin-forms')); ?>

			<?php
				echo $this->Form->input('id', array('disabled' => 'disabled'));
				echo $this->Form->input('name', array('disabled' => 'disabled'));
				echo $this->Form->input('status', array('options' => $status, 'disabled' => 'disabled'));
			?>
		<?php /*echo $this->Form->end('Submit');*/ ?>

	</div>

</div>
