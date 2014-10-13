<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />

		<div class="coupons form">
		<?php echo $this->Form->create('Coupon',array('class'=>'admin-forms')); ?>
			
			<legend><?php echo __('Add Coupon'); ?></legend>
			<?php
				echo $this->Form->input('name');
				echo $this->Form->input('promocode');
				echo $this->Form->input('datestart');
				echo $this->Form->input('dateend');
				echo $this->Form->input('discountamount', array('type'=>'text'));
				
				$options = array('Ship'=>'Ship','Shop'=>'Shop', 'Product'=>'Product');
				echo $this->Form->input('type',array('options'=>$options));
				
				echo $this->Form->input('minimumamount', array('type'=>'text'));
				echo $this->Form->input('available');
				echo $this->Form->input('remaining', array('type'=>'text'));
				echo $this->Form->input('details');
				
				$options = array('active'=>'Active','inactive'=>'Inactive');
				echo $this->Form->input('status',array('options'=>$options));
				//echo $this->Form->input('dateadded');
			?>

		<?php echo $this->Form->end(__('Submit')); ?>
		</div>
		<!-- <div class="actions">
			<h3><?php /*echo __('Actions');*/ ?></h3>
			<ul>

				<li><?php /*echo $this->Html->link(__('List Coupons'), array('action' => 'index'));*/ ?></li>
			</ul>
		</div> -->
	</div>	

</div>