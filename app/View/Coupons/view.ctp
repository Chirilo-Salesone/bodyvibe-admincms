<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />

		<div class="coupons view">
		<h2><?php echo __('Coupon'); ?></h2>
			<dl>
				<dt><?php echo __('Id'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Name'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['name']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Promo Code'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['promocode']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Start Date'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['datestart']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('End Date'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['dateend']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Discount Amount'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['discountrate']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Type'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['type']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Coupon Minimum Amount'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['minimumamount']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Available'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['available']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Remaining'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['remaining']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Details'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['details']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Status'); ?></dt>
				<dd>
					<?php echo h($coupon['Coupon']['status']); ?>
					&nbsp;
				</dd>
				
			</dl>
		</div>
	</div>	
</div>
<!-- <div class="actions">
	<h3><?php /*echo __('Actions');*/ ?></h3>
	<ul>
		<li><?php /*echo $this->Html->link(__('Edit Coupon'), array('action' => 'edit', $coupon['Coupon']['id']));*/ ?> </li>
		<li><?php /*echo $this->Form->postLink(__('Delete Coupon'), array('action' => 'delete', $coupon['Coupon']['id']), null, __('Are you sure you want to delete # %s?', $coupon['Coupon']['id']));*/ ?> </li>
		<li><?php /*echo $this->Html->link(__('List Coupons'), array('action' => 'index'));*/ ?> </li>
		<li><?php /*echo $this->Html->link(__('New Coupon'), array('action' => 'add'));*/ ?> </li>
	</ul>
</div> -->
