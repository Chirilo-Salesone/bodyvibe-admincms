<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />
		
		<?php echo $this->Form->create('Coupon',array('class'=>'admin-forms')); ?>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('name');
			echo $this->Form->input('promocode');
			echo $this->Form->input('datestart');
			echo $this->Form->input('dateend');
			echo $this->Form->input('discountrate');
			echo $this->Form->input('type',array('label'=>'Coupon Type',
				                                 'options'=>
				                                       array('product'=>'Product',
				                                       	     'ship'=>'Ship',
				                                       	     'shop'=>'Shop')));
			echo $this->Form->input('minimumamount');
			echo $this->Form->input('available');
			echo $this->Form->input('remaining');
			echo $this->Form->input('details');
			echo $this->Form->input('status',array('options'=>array('inactive'=>'Inactive','active'=>'Active')));
			
		?>
		
		<?php echo $this->Form->end('Submit'); ?>		

	</div>	

</div>
<script type="text/javascript">

	(function($){

		$( "#CouponStartDate" ).datepicker();

		$( "#CouponEndDate" ).datepicker();

	}(jQuery))

</script>
