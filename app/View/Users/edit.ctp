<div class="customers form">
<?php echo $this->Form->create('Customer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Customer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('cust_newsletter');
		echo $this->Form->input('retailSiteLink');
		echo $this->Form->input('piercingServices');
		echo $this->Form->input('cust_default_address');
		echo $this->Form->input('cust_date_added');
		echo $this->Form->input('cust_last_modified');
		echo $this->Form->input('cust_ship_fname');
		echo $this->Form->input('cust_ship_lname');
		echo $this->Form->input('cust_ship_company_name');
		echo $this->Form->input('cust_ship_street_address');
		echo $this->Form->input('cust_ship_street_address2');
		echo $this->Form->input('cust_ship_postcode');
		echo $this->Form->input('cust_ship_country');
		echo $this->Form->input('cust_ship_state');
		echo $this->Form->input('cust_ship_city');
		echo $this->Form->input('cust_ship_phone');
		echo $this->Form->input('cust_ship_fax');
		echo $this->Form->input('cust_bill_fname');
		echo $this->Form->input('cust_bill_lname');
		echo $this->Form->input('cust_bill_company_name');
		echo $this->Form->input('cust_bill_street_address');
		echo $this->Form->input('cust_bill_street_address2');
		echo $this->Form->input('cust_bill_postcode');
		echo $this->Form->input('cust_bill_country');
		echo $this->Form->input('cust_bill_state');
		echo $this->Form->input('cust_bill_city');
		echo $this->Form->input('cust_bill_phone');
		echo $this->Form->input('cust_bill_fax');
		echo $this->Form->input('cust_business_type');
		echo $this->Form->input('cust_business_value');
		echo $this->Form->input('cust_business_license');
		echo $this->Form->input('websiteAddress');
		echo $this->Form->input('cust_type');
		echo $this->Form->input('cust_gender');
		echo $this->Form->input('cust_age');
		echo $this->Form->input('cust_hear');
		echo $this->Form->input('cust_hear_value');
		echo $this->Form->input('cust_salesrep');
		echo $this->Form->input('cust_credit_point');
		echo $this->Form->input('cust_credit_added');
		echo $this->Form->input('mode_cust');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Customer.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Customer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Customers'), array('action' => 'index')); ?></li>
	</ul>
</div>
