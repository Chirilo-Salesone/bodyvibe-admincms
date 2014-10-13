<style type="text/css">
	.row input[type=text], select{
		width: 70% !important;
	}
</style>
<div class="row">
	<div class="col-md-12">

	<div class="row">

		<div class="col-md-12">

			<a href="<?php echo $this->request->referer();?>" class="btn btn-default btn-md pull" role="button">
		  		<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
			</a>			

			<hr/>
		</div>

	</div>

	<?php

		/*echo '<pre>';

			print_r($customer_details);

		echo '</pre>';*/

	?>

	<?php echo $this->Form->create('Customer',array('class'=>'admin-forms customer-form')); ?>
		<?php $optionsArr = array('active'=>'Active','inactive'=>'Inactive'); ?>

	<!-- Log-In Information - Account Name(Email) and Password -->
		<!-- table wrapper -->
		<div class="row">
			
			<div class="col-md-6">
				

			
				<div class="table-responsive">
					<h1 class="page-header">Log-In Information - Account Name(Email) and Password</h1>
					<table class="table  table-bordered table-condensed">
				
						<tbody>
							<tr>
								<th> Username </th>
								<td> 
									<?php 
										 echo $this->Form->input('email', array('type'=>'text', 'label' => false) );
									?> 
								</td>
							</tr>
							<tr><th> Password </th><td> <?php echo $this->Form->input('password',array('type'=>'text', 'label' => false)); ?> </td></tr>
							<tr><th> Account Created </th><td> <?php echo $this->Form->input('added',array('type'=>'text', 'label' => false));?> </td></tr>
							<tr><th> Newsletter </th><td> <?php echo $this->Form->input('newsletter',array('options'=>$optionsArr, 'label' => false)); ?></td></tr>
							
						</tbody>
					</table>	

				</div>

			</div>

		</div>
	<!-- end of Log-In Information - Account Name(Email) and Password -->


	<!-- Billing Information -->
	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<h1 class="page-header">Billing Information</h1>
				<table class="table  table-bordered table-condensed">
					<tbody>
						<tr>
							<th> Company Name </th>
							<td> <?php echo $this->Form->input('bill_company',array('type'=>'text', 'label' => false)); ?> </td>
						</tr>
						<tr>
							<th> First Name </th>
							<td> <?php echo $this->Form->input('bill_fname',array('type'=>'text', 'label' => false))?> </td>
						</tr>
						<tr><th> Last Name </th><td> <?php echo $this->Form->input('bill_lname',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> Address  </th><td> <?php echo $this->Form->input('bill_street',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> City(Non-USA,Canada) </th><td> <?php echo $this->Form->input('bill_city',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> State </th><td> <?php echo $this->Form->input('bill_state',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> Zip Code </th><td> <?php echo $this->Form->input('bill_postcode',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr>
							<th> Country </th>
							<td> 
								<?php 
									$selected = array_search($customer_details['Customer']['bill_country'], $countries);
									echo $this->Form->input('ship_country',array('type'=>'select', 'options' => $countries, 'value' => $selected, 'label' => false))?> 

							</td>
						</tr>
						<tr><th> Day-Time Phone </th><td> <?php echo $this->Form->input('bill_phone',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> Fax (optional) </th><td> <?php echo $this->Form->input('bill_fax',array('type'=>'text', 'label' => false))?> </td></tr>
					</tbody>
				</table>	

			</div>
		</div>
	</div>
	<!-- end of Billing Information -->

	<!-- Shipping Information -->
	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<h1 class="page-header">Shipping Information</h1>
				<table class="table  table-bordered table-condensed">
					<tbody>
						<tr>
							<th> Company Name </th>
							<td> <?php echo $this->Form->input('ship_company',array('type'=>'text', 'label' => false)); ?> </td>
						</tr>
						<tr>
							<th> First Name </th>
							<td> <?php echo $this->Form->input('ship_fname',array('type'=>'text', 'label' => false))?> </td>
						</tr>
						<tr><th> Last Name </th><td> <?php echo $this->Form->input('ship_lname',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> Address  </th><td> <?php echo $this->Form->input('ship_street',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> City(Non-USA,Canada) </th><td> <?php echo $this->Form->input('ship_city',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> State </th><td> <?php echo $this->Form->input('ship_state',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> Zip Code </th><td> <?php echo $this->Form->input('ship_postcode',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr>
							<th> Country </th>
							<td> 
								<?php 
									$selected = array_search($customer_details['Customer']['ship_country'], $countries);
									echo $this->Form->input('ship_country',array('type'=>'select', 'options' => $countries, 'value' => $selected, 'label' => false))?> 

							</td>
						</tr>
						<tr><th> Day-Time Phone </th><td> <?php echo $this->Form->input('ship_phone',array('type'=>'text', 'label' => false))?> </td></tr>
						<tr><th> Fax (optional) </th><td> <?php echo $this->Form->input('ship_fax',array('type'=>'text', 'label' => false))?> </td></tr>
					</tbody>
				</table>	

			</div>
		</div>
	</div>
	<!-- end of Shipping Information -->

	<?php
		/*echo '<pre>';
			print_r($this->data['Customer']);
		echo '</pre>';*/
	?>
	
	<!-- Sales Representative -->
	<div class="row">
		<div class="col-md-6">
			<div class="table-responsive">
				<h1 class="page-header">Sales Representative</h1>
				<table class="table  table-bordered table-condensed">
					<tbody>
						<tr>
							<th> Salesrep </th>
							<td> 
								<?php 

									if( isset($this->data['Customer']['salesrep_id']) && $this->data['Customer']['salesrep_id'] != 0 ){
										if( $this->data['Customer']['salesrep_id'] != 0 ){
											echo $this->Form->input('salesrep_id', array('type' => 'select', 'options' => $salesreps, 'value' => $this->data['Customer']['salesrep_id'], 'label' => false ));
										}
									}
									/*elseif( isset($this->data['Customer']['salesrep']) && $this->data['Customer']['salesrep'] != '' ){
										if( $this->data['Customer']['salesrep'] != '' ){
											$salesrep_name_key = array_search($this->data['Customer']['salesrep'], $salesreps);
											echo $this->Form->input('salesrep_id', array('type' => 'select', 'options' => $salesreps, 'value' => $salesrep_name_key, 'label' => false ));
										}
										elseif( $this->data['Customer']['salesrep'] == '' ){
											$salesreps[0] = 'Select salesrep.';
											echo $this->Form->input('salesrep_id', array('type' => 'select', 'options' => $salesreps, 'value' => 0, 'label' => false));
										}
									}*/
									else{
										$salesreps[0] = 'Select salesrep';
										echo $this->Form->input('salesrep_id', array('type' => 'select', 'options' => $salesreps, 'value' => 0, 'label' => false));
									}
										
										/*echo $this->Form->input('salesrep_id',array('type'=>'text')); */
									
								?> 
							</td>
						</tr>
					</tbody>
				</table>	

			</div>
		</div>
	</div>
	<!-- end of Sales Representative -->

	<?php echo $this->Form->end('Submit', array('class' => 'btn btn-default btn-md pull')); ?>

	<?php 
		/*echo '<pre>';
			print_r($customer_details);
		echo '</pre>';*/
	?>


	<!-- Sales Representative -->
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<h1 class="page-header">Orders List</h1>
				<table class="table  table-bordered table-condensed">
					<thead style="border-bottom: 1px solid #ccc;">
						<tr>
							<th>Order Date</th>
							<th>Order No</th>
							<th>Ups Tracking #</th>
							<th>Order Total</th>
							<th>Order Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if( empty($customer_orders) ){
						?>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td style="text-align: center;"></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td style="text-align: center;"> <strong>NO RECORD TO DISPLAY</strong></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
						<?php
							}
							else{
								$order_hierarchy = 1;
								foreach($customer_orders as $key => $cust_order){
						?>
								<tr>
									<td>
										<?php
											echo date('M d, Y @ H:i:s', strtotime($cust_order['Order']['added']));
										?>
									</td>
									<td>
										<?php
											echo '<strong>'. $order_hierarchy .'</strong>'
										?>
									</td>
									<td >
										<?php
											if( !empty($cust_order['OrderTracking']['tracking_number']) ){
												echo $cust_order['OrderTracking']['tracking_number'];
											}
											else{
												echo '- no tracking info - ';
											}
										?>
									</td>
									<td>
										<?php
											echo '$'.number_format($cust_order['Payment']['charge'], 2, '.', ', ');
										?>
									</td>
									<td>
										<?php
											/*echo $cust_order['Order']['mode'];*/
										?>
										<?php

											switch ($cust_order['Order']['mode']) {
												case 'new-order':
													# code...
													echo '<strong style="color: #008000">'.ucwords($cust_order['Order']['mode']).'</strong>';
													break;
												
												case 'processing':
													# code...
													echo '<strong style="color: #FFA500">'.ucwords($cust_order['Order']['mode']).'</strong>';
													break;

												case 'declined':
													# code...
													echo '<strong style="color: #808080">'.ucwords($cust_order['Order']['mode']).'</strong>';
													break;

												case 'shipped':
													# code...
													echo '<strong style="color: #0000FF">'.ucwords($cust_order['Order']['mode']).'</strong>';
													break;

												case 'processed-offline':
													# code...
													echo '<strong style="color: #FF0000">'.ucwords($cust_order['Order']['mode']).'</strong>';
													break;
											}

										?>
									</td>
								</tr>
						<?php
								$order_hierarchy++;
								}
							}
						?>
						
					</tbody>
				</table>	

			</div>
		</div>
	</div>
	<!-- end of Sales Representative -->

	

			<?php

				

				/*echo $this->Form->input('id');
				echo $this->Form->input('email', array('label'=>'Email Address','type'=>'text') );
				echo $this->Form->input('password',array('type'=>'text'));
				echo $this->Form->input('newsletter',array('label'=>'Newsletter Receiver?','options'=>$optionsArr));
				echo $this->Form->input('retailsitelink',array('label'=>'Have Retail Site Link','options'=>$optionsArr));
				echo $this->Form->input('piercingservices',array('label'=>'Have Piercing Services?','options'=>$optionsArr));
				echo $this->Form->input('ship_fname');
				echo $this->Form->input('ship_lname');
				echo $this->Form->input('ship_company');
				echo $this->Form->input('ship_address');
				echo $this->Form->input('ship_address2');
				echo $this->Form->input('ship_postcode');
				echo $this->Form->input('ship_country');
				echo $this->Form->input('ship_state');
				echo $this->Form->input('ship_city');
				echo $this->Form->input('ship_phone');
				echo $this->Form->input('ship_fax');
				echo $this->Form->input('bill_fname');
				echo $this->Form->input('bill_lname');
				echo $this->Form->input('bill_company');
				echo $this->Form->input('bill_address');
				echo $this->Form->input('bill_address2');
				echo $this->Form->input('bill_postcode');
				echo $this->Form->input('bill_country');
				echo $this->Form->input('bill_state');
				echo $this->Form->input('bill_city');
				echo $this->Form->input('bill_phone');
				echo $this->Form->input('bill_fax');
				echo $this->Form->input('business_type');
				echo $this->Form->input('business_value');
				echo $this->Form->input('business_license');
				echo $this->Form->input('website');
				echo $this->Form->input('type');
				echo $this->Form->input('gender');
				echo $this->Form->input('age');
				echo $this->Form->input('hear');
				echo $this->Form->input('hear_value');
				echo $this->Form->input('salesrep',array('label'=>'Sales Rep','type'=>'text'));
				echo $this->Form->input('mode');*/
			?>
			<?php /*echo $this->Form->end('Submit');*/ ?>

	</div>

</div>
