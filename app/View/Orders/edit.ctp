<style type="text/css">
	
form#TrackingInfoEditForm label{
	width: 23% !important;
}

form#TrackingInfoEditForm input, textarea{
	width:250px !important;
}

form#TrackingInfoEditForm input[type="submit"]{
	width:100px !important;
	margin-top: 10px;
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

	<br/>	

		<!-- table wrapper -->
		<div class="table-responsive">

			<table class="table  table-bordered table-condensed">
			
				<tr class="active">
					<th> Customer Name </th>
					<th> Email </th>
					<th> Phone No </th>
					<!-- <th> Salesrep </th> -->
					<!-- <th> Payment </th> -->
					<th> Added </th>
					<th> Modified </th>
					
				</tr>	

				<tbody>
					<td> 
						<?php 
							 echo $customerName = $datas['OrderCustomer']['ship_fname']." ".$datas['OrderCustomer']['ship_lname'];
						?> 
					</td>
					<td> <?php echo $datas['OrderCustomer']['email']?> </td>
					<td> <?php echo $datas['OrderCustomer']['ship_phone']?> </td>
					<!-- <td> <?php /*echo ucfirst($datas['OrderSalesrep']['name']);*/?> </td>
					<td> <?php /*echo $datas['Payment']['name']*/?> </td> -->
					<td> <?php echo date_format( new DateTime($datas['OrderCustomer']['added']),'M d, Y H:i:s a')?> </td>
					<td> <?php 
							
							if($datas['OrderCustomer']['modified']!="0000-00-00 00:00:00"){
								echo date_format( new DateTime($datas['OrderCustomer']['modified']),'M d, Y H:i:s');
							}
							else{
								echo "not modified";
							}	
						?> </td>
					
				</tbody>
			</table>	

		</div>	

		<div class="row">
			
				<div class="col-md-6"> 

							<h1 class="page-header"> Billing Information </h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed">
								
									<tr>
										<th class="active col-md-3"> Company </th>
										<td> <?php echo $datas['OrderCustomer']['bill_company']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Street </th>
										<td> <?php echo $datas['OrderCustomer']['bill_street']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> City </th>
										<td> <?php echo $datas['OrderCustomer']['bill_city']?></td>
									</tr>	

									<tr>
										<th class="active col-md-3"> State </th>
										<td> <?php echo $datas['OrderCustomer']['bill_state']?> </td>
									</tr>	

									<tr>
										<th class="active col-md-3"> Country </th>
										<td> <?php echo $datas['OrderCustomer']['bill_country']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Zip </th>
										<td> <?php echo $datas['OrderCustomer']['bill_postcode']?> </td>
									</tr>										


								</table>	

							</div>				

				</div>

				<div class="col-md-6"> 

							<h1 class="page-header"> Shipping Information </h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed">
								
									<tr>
										<th class="active col-md-3"> Company </th>
										<td> <?php echo $datas['OrderCustomer']['ship_company']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Street </th>
										<td> <?php echo $datas['OrderCustomer']['ship_street']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> City </th>
										<td> <?php echo $datas['OrderCustomer']['ship_city']?></td>
									</tr>	

									<tr>
										<th class="active col-md-3"> State </th>
										<td> <?php echo $datas['OrderCustomer']['ship_state']?> </td>
									</tr>	

									<tr>
										<th class="active col-md-3"> Country </th>
										<td> <?php echo $datas['OrderCustomer']['ship_country']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Zip </th>
										<td> <?php echo $datas['OrderCustomer']['ship_postcode']?> </td>
									</tr>										


								</table>	

							</div>				

				</div>	

				<div class="col-md-6"> 

							<h1 class="page-header"> Order Summary Amount </h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed custom-admin-listing">
								
									<tr>
										<th class="active col-md-3"> Total Amount </th>
										<td> 
											$ <?php 
												/*echo $datas['Payment']['charge']*/ 
												echo number_format($datas['Payment']['charge'], 2, '.', ' ,');
											?> 
										</td>
									</tr>	

								</table>	

							</div>				

				</div>		

				<?php /*sales rep*/ ?>
				<div class="col-md-6"> 

					<h1 class="page-header"> Sales Representative </h1>
					<div class="table-responsive">
						
						<table class="table  table-bordered table-condensed custom-admin-listing">
							<?php
								if( isset($datas['Customer']['salesrep_id']) && $datas['Customer']['salesrep_id'] != 0 ){
							?>
									<tr>
										<th class="active col-md-3"> Sales Representative </th>
										<td> <?php echo ucfirst( $salesreps[$datas['Customer']['salesrep_id']] );?> </td>
									</tr>
							<?php
								}
								elseif( isset($datas['Customer']['salesrep']) && $datas['Customer']['salesrep'] != '' ){
							?>
									<tr>
										<th class="active col-md-3"> Sales Representative </th>
										<td> <?php echo ucfirst( $datas['Customer']['salesrep'] );?> </td>
									</tr>
							<?php
								}
								else{
							?>
									<tr>
										<th class="active col-md-3"> Sales Representative </th>
										<td> User has no Sales Representative </td>
									</tr>
							<?php
								}
							?>
								

						</table>	

					</div>				

				</div>	
				<?php /*end of sales rep*/ ?>


				<?php /* Package Widget */ ?>
				
				<div class="col-md-6"> 
					<h1 class="page-header"> Package </h2>
						<div class="table-responsive">

							<table class="table  table-bordered table-condensed custom-admin-listing">
							
								<tr>
									<th class="active col-md-3"> Package Cost </th>
									<td> 
										$ <?php 
											/*echo $datas['OrderPackage']['cost']*/
											/*echo number_format($datas['OrderPackage']['cost'], 2, '.', ' ,')*/
											/*
											* AS of OCt. 9, 2014 - correct calculation is package cost * total_product_qty in Order
											*/
											echo number_format( $datas['OrderPackage']['cost'] , 2, '.', ' ,');
										
										?> 
									</td>
								</tr>	

							</table>	

						</div>				

				</div>		
				<?php /* end of Package Widget */ ?>

				<?php 
					/* for Customer's Coupon */
					if( $datas['OrderCoupon']['id'] != 0 ){
				?>
						<div class="col-md-6"> 

							<h1 class="page-header"> Coupon </h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed custom-admin-listing">
								
									<tr>
										<th class="active col-md-3"> Coupon Name </th>
										<td><?php echo $datas['OrderCoupon']['name']?> </td>
									</tr>	

									<tr>
										<th class="active col-md-3"> Coupon Details </th>
										<td><?php echo $datas['OrderCoupon']['details']?> </td>
									</tr>

									<tr>
										<th class="active col-md-3"> Promo Code </th>
										<td><?php echo $datas['OrderCoupon']['promocode']?> </td>
									</tr>

									<tr>
										<th class="active col-md-3"> Discount Rate </th>
										<td> $ <?php echo $datas['OrderCoupon']['discountrate']?> </td>
									</tr>

								</table>	

							</div>				

						</div>		
				<?php 
					}
					else{
				?>
						<div class="col-md-6"> 

							<h1 class="page-header"> Coupon </h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed custom-admin-listing">
								
									<tr>
										<th class="active col-md-3"> Coupon Details </th>
										<td> User has no Coupon  </td>
									</tr>	

									<!-- <tr>
										<th class="active col-md-3"> Coupon Details </th>
										<td><?php echo $datas['OrderCoupon']['details']?> </td>
									</tr>

									<tr>
										<th class="active col-md-3"> Promo Code </th>
										<td><?php echo $datas['OrderCoupon']['promocode']?> </td>
									</tr>

									<tr>
										<th class="active col-md-3"> Discount Rate </th>
										<td> $ <?php echo $datas['OrderCoupon']['discountrate']?> </td>
									</tr> -->

								</table>	

							</div>				

						</div>	
				<?php
					}
					/* end for Customer's Coupon */
				?>



		</div>
		<div class="row">

		</div>


		<?php 
			/*pr( $productdatas );*/
		?>

		
		<h2 class="page-header"> Product Details </h2>
		<br/>

		<!-- table wrapper -->
		<div class="table-responsive">

			<table class="table table-hover table-bordered table-condensed custom-admin-listing">
			
				<thead class="active">
					<th> Image </th>
					<th> Number </th>
					<th> Color </th>
					<th> Qty</th>
					<th> Unit Price</th>
					<th> Discount (%) </th>
					<th> Total </th>
				</thead>	

				<tbody>
				<?php foreach($productdatas as $productdata){ ?>
					<?php
						/*echo '<pre>';
							print_r($productdata);
						echo '</pre>';*/
					?>
					<tr>
						
						<td width="104"> 
							<?php
								$product_image_path = PRODUCTS_IMAGES_THUMBS.$productdata['OrderProduct']['image_name'].'.jpg';
								if( @getimagesize($product_image_path) ){
							?>
									<img src="<?php echo PRODUCTS_IMAGES_THUMBS.$productdata['OrderProduct']['image_name']; ?>.jpg" height="104" width="104" />  
							<?php
								}
								else{
							?>
									<img src="<?php echo PRODUCTS_IMAGES_THUMBS; ?>notavailable.jpg" height="104" width="104" />  
							<?php
								}
							?>
							
						</td>
						<td> <?php echo $productdata['OrderProduct']['number']; ?> </td>						
						<td> <?php echo $productdata['Color']['name']; ?> </td>				
						<td> <?php echo $productdata['OrderDetail']['qty']. ' pcs'; ?> </td>
						
						<?php
							/* 
							* used for product discounted price and product discount value
							* based on the calculation by Zach Tanzinco - sep 24, 2014 
							*/
							$discount_value_for_each_product = '';	/* product discount value */
							$discounted_price_for_each_product = 0;
							$total_calculated_amount_for_each_product = 0;
							if( $productdata['OrderDetail']['qty'] <= 2 ){	/* 1-2 products */
								
								/* check if product has discount_value */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
								}
								elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '0.00%';
								}
								
								/* For special discount_values (e.g. 75%) */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
									/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}
								else{
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'];
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}
								
							}
							elseif( $productdata['OrderDetail']['qty'] == 3 || $productdata['OrderDetail']['qty'] <= 5 ){
								
								/* check if product has discount_value - for discount_Value display on product details */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
								}
								elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '15.00%';
								}

								/* For special discount_values (e.g. 75%) */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
									/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}
								else{
									/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.15), 2, '.', ', ');*/
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.15);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}

								
							}
							elseif( $productdata['OrderDetail']['qty'] == 6 || $productdata['OrderDetail']['qty'] <= 11 ){
								
								/* check if product has discount_value */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
								}
								elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '25.00%';
								}

								/* For special discount_values (e.g. 75%) */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
									/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.75), 2, '.', ', ');*/
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}
								else{
									/*$the_discount_value = number_format( ($productdata['OrderProduct']['price'] * 0.25), 2, '.', ', ');*/
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.25);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}

								
							}
							elseif( $productdata['OrderDetail']['qty'] >= 12 ){
								
								/* check if product has discount_value */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $productdata['OrderProduct']['discount_value'].'%';
								}
								elseif( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '35.00%';
								}

								/* For special discount_values (e.g. 75%) */
								if( isset( $productdata['OrderProduct']['discount_value'] ) && $productdata['OrderProduct']['discount_value'] == 75.00 ){
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.75);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}
								else{
									$the_discount_value = ($productdata['OrderProduct']['price'] * 0.35);
									$discounted_price_for_each_product = $productdata['OrderProduct']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $productdata['OrderDetail']['qty'] * number_format($discounted_price_for_each_product, 2, '.', ', ');
								}

								
							}
						?>

						<td>
							<?php 
								/*echo '$'.$productdata['OrderProduct']['price'];*/ 
								/*echo '$'.number_format($productdata['OrderProduct']['price'], 2, '.', ' ,');*/
								echo '$'.number_format($discounted_price_for_each_product, 2, '.', ' ,'); /* sep 24, 2014 */
							?>
						</td>

						<td>
							<?php 
								/*echo $productdata['OrderProduct']['discount_value'].'%'; */ /* temporary commented out - sep 2014 */
								echo $discount_value_for_each_product; /* sep 24, 2014 */
							?>
						</td>
						<td> 
							<?php 
								/*$productAmount = ($productdata['OrderDetail']['qty'] * $productdata['OrderProduct']['price']); 
								echo "$".number_format($productAmount,2,'.', ' ,');*/
								echo '$'.number_format($total_calculated_amount_for_each_product, 2, '.', ' ,');
							?> 
						</td>
					</tr>

					<?php } ?>
				</tbody>

			</table>
		</div>
		<!-- table wrapper -->		


		<!-- order details -->
		<?php
			/*pr( $productdatas );*/
			$totalWeight = 0;
			foreach( $productdatas as $productdata ){
				$totalWeight += ($productdata['OrderProduct']['weight'] * $productdata['OrderDetail']['qty']);
			}
		?>
		<h2 class="page-header"> Total Weight </h2>
		<div class="table-responsive">

			<table class="table  table-bordered table-condensed">
			
				<tr>
					<th class="active col-md-3"> Total Weight </th>
					<td> 
						<?php /*echo $datas['OrderCustomer']['bill_company']*/?>
						<?php echo $totalWeight.'lbs';?> 
					</td>
				</tr>	
			</table>	

		</div>			

		<h2 class="page-header"> Order Total </h2>
		<div class="table-responsive">

			<table class="table  table-bordered table-condensed">
			
				<tr>
					<th class="active col-md-3"> Subtotal </th>
					<td> 
						<?php
							if( $datas['Payment']['name'] == 'cod' ){
						?>
							<?php 
								if( $datas['OrderPackage']['cost'] != null ){
									echo '$'. number_format( ( (($datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice']) - 12) - $datas['OrderPackage']['cost'] ), 2, '.', ', ');
								}
								else{
									echo '$'. number_format( ( (($datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice']) - 12) ), 2, '.', ', ');
								}
								/*echo '$'. number_format( ( ($datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice']) - 12 ), 2, '.', ' ,');*/
							?>
						<?php
							}
							else{
						?>
							<?php 
								echo '$'. number_format( ($datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice']), 2, '.', ', ');
							?> 
						<?php
							}
						?> 
					</td>
				</tr>	
				<tr>
					<th class="active col-md-3"> Shipping </th>
					<td> <?php echo '+ $'. number_format($datas['Shipping']['upsServicePrice'], 2, '.', ', ').' (<b> '. $datas['Shipping']['upsServiceName'] .'</b> )'?> </td>
				</tr>
				<tr>
					<th class="active col-md-3"> Payment </th>
					<?php
						if( $datas['Payment']['name'] == 'cod' ){
					?>
							<td> <?php echo '+ $12.00 <b>('.ucfirst(str_replace('_',' ',$datas['Payment']['name'])).')';?></b> </td>
					<?php
						}
						else{
					?>
							<td> <?php echo '+ 0.00 <b>('.ucfirst(str_replace('_',' ',$datas['Payment']['name'])).')';?></b> </td>
					<?php
						}
					?>
					
				</tr>
				<tr>
					<th class="active col-md-3"> Packaging Charge </th>
					<td> <?php echo '+ $'.$datas['OrderPackage']['cost']?> </td>
				</tr>

				<tr>
					<th class="active col-md-3"> Coupon Discount </th>
					<td> 
						<?php
							if( $datas['OrderCoupon']['id'] != 0 ){
								echo '- $'.number_format($datas['OrderCoupon']['discountrate'], 2, '.', ' ,');
							}
							else{
								echo '- $0.00';
							}
							/*echo $datas['OrderCoupon']['discountrate'];*/
						?> 
					</td>
				</tr>
				<tr>
					<th class="active col-md-3"> Volume Discount </th>
					<td> <?php echo '- $'.number_format($datas['Order']['volumediscount'], 2, '.', ' ,')?> </td>
				</tr>

				<tr>
					<th class="active col-md-3"> Total Amount </th>
					<td> 
						<?php /*echo $datas['OrderCustomer']['bill_company']*/?>
						<?php
							$subtotal_amount = $datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice'];
						?> 
						<?php 
							/*$totalAmount = ($datas['Payment']['charge'] + $datas['Shipping']['upsServicePrice']);*/ 
							$totalAmount = ($subtotal_amount + $datas['Shipping']['upsServicePrice']);
							echo "$".number_format($totalAmount,2,'.', ' ,');
						?> 
					</td>
				</tr>
				<tr>
					<th class="active col-md-3"> Amount Status </th>
					<td> 
						<?php /*echo $datas['Order']['mode']*/?> 
						<select id="order_mode">
							<?php
								if( $datas['Order']['mode'] == 'new-order' ){
							?>
									<option value="new-order" selected> New Order </option>
									<option value="processing"> Processing </option>
									<option value="declined"> Declined </option>
									<option value="shipped"> Shipped </option>
									<option value="processed-offline"> Processed Offline </option>
							<?php
								}
								elseif( $datas['Order']['mode'] == 'processing' ){
							?>
									<option value="new-order"> New Order </option>
									<option value="processing" selected> Processing </option>
									<option value="declined"> Declined </option>
									<option value="shipped"> Shipped </option>
									<option value="processed-offline"> Processed Offline </option>
							<?php
								}
								elseif( $datas['Order']['mode'] == 'declined' ){
							?>
									<option value="new-order"> New Order </option>
									<option value="processing"> Processing </option>
									<option value="declined" selected> Declined </option>
									<option value="shipped"> Shipped </option>
									<option value="processed-offline"> Processed Offline </option>
							<?php
								}
								elseif( $datas['Order']['mode'] == 'shipped' ){
							?>
									<option value="new-order"> New Order </option>
									<option value="processing"> Processing </option>
									<option value="declined"> Declined </option>
									<option value="shipped" selected> Shipped </option>
									<option value="processed-offline"> Processed Offline </option>
							<?php
								}
								elseif( $datas['Order']['mode'] == 'processed-offline' ){
							?>
									<option value="new-order"> New Order </option>
									<option value="processing"> Processing </option>
									<option value="declined"> Declined </option>
									<option value="shipped"> Shipped </option>
									<option value="processed-offline" selected> Processed Offline </option>
							<?php
								}
							?>
							
						</select>
					</td>
				</tr>
			</table>	

		</div>		
		<!-- end of order details -->


		<?php 
			/* Current Shipping Information */ 
			if( isset($this->request->data['Shipping']['id']) ){
		?>
		<h2 class="page-header"> Current Shipping Information - test </h2>
		<div class="row">
			<div class="col-md-6"> 

				<div class="table-responsive">

					<table class="table  table-bordered table-condensed custom-admin-listing">
					
						<tr>
							<th class="active col-md-3"> Country </th>
							<td><?php echo $this->request->data['Shipping']['country']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> Zip Code </th>
							<td><?php echo $this->request->data['Shipping']['zip']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> UPS Service Price </th>
							<td> $ <?php echo $this->request->data['Shipping']['upsServicePrice']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> UPS Service Name </th>
							<td><?php echo $this->request->data['Shipping']['upsServiceName']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> Transaction Date </th>
							<td> <?php echo date('M d, Y H:i:s',strtotime($this->request->data['Shipping']['date_transacted']))?> </td>
						</tr>	

					</table>	

				</div>				

			</div>		
		</div>
		<?php 
			}
			/* end of Current Shipping Information */ 
		?>


		<!-- Order Status/Tracking Information -->
		<h2 class="page-header"> Tracking Information </h2>
		<div class="row">
			<div class="col-md-6">
				<?php
					/*if( isset($datas['OrderTracking']['id']) ){*/
					if( $datas['Order']['mode'] != 'new-order' ){	/* based on the order not on ordertracking - oct 2, 2014 */
				?>
						<table class="table  table-bordered table-condensed custom-admin-listing">
							<!-- <tbody> -->
								<tr>
									<th><center> DATE ADDED </center></th>
									<th><center> STATUS </center></th>
									<th><center> CUSTOMER NOTIFIED </center></th>
								</tr>
							
								<tr> 
									<!-- <td align="center"> <?php /*echo date('F j, Y', strtotime($datas['OrderTracking']['shipdate']));*/ ?> </td> -->
									<td align="center"> <?php echo date('F j, Y', strtotime($datas['Order']['added'])); ?> </td>
									<td align="center" id="td_order_mode" style="text-transform: capitalize;"> <?php echo $datas['Order']['mode']?> </td>
									<td align="center"> Yes </td>
								</tr>
							<!-- </tbody> -->
						</table>
				<?php
					}
					else{
				?>
						<table class="table  table-bordered table-condensed custom-admin-listing">
							<!-- <tbody> -->
								<tr>
									<th><center> DATE ADDED </center></th>
									<th><center> STATUS </center></th>
									<th><center> CUSTOMER NOTIFIED </center></th>
								</tr>
							
								<tr> 
									<td> &nbsp;&nbsp; </td>
									<td align="center">-- NO TRACKING INFO --</td>
									<td>&nbsp;&nbsp;</td>
								</tr>
							<!-- </tbody> -->
						</table>
				<?php
					}
				?>
			</div>
		</div>
		<div class="row">

			<div class="col-md-6"> 

				<div class="table-responsive">
					<!-- <form name="orderTracker" id="orderTracker" method="post" enctype="multipart/form-data"> -->
					<?php
						/*pr( $datas['OrderTracking'] );*/
					?>
					<?php
						$options = array();
						$options['url'] = array();
						$options['url']['controller'] = "Orders";
						$options['url']['action'] = "save_tracking_info/".$this->request->params['pass'][0];
						$options['enctype'] = "multipart/form-data"; 
						/*$options['type'] = 'file';*/
						echo $this->Form->create('TrackingInfo', $options);
					?>
						<table class="table  table-bordered table-condensed custom-admin-listing">
							
							<?php
								if( isset($datas['OrderTracking']['id']) ){
									echo $this->Form->input('id', array('type' => 'hidden', 'default' => $datas['OrderTracking']['id']));
								}
							?>
								
							<tr>
								<!-- <th class="active col-md-3"> Country </th> -->
								<!-- <td width="20%" align="center"> Tracking Number </td> -->
								<td> 
									<!-- <input type="text" size='35' name="trackingNumber" id="trackingNumber" />  -->
									<?php 
										if( isset($datas['OrderTracking']['id']) ){
											echo $this->Form->input('trackingNumber', array('default' => $datas['OrderTracking']['tracking_number']));
										}
										else{
											echo $this->Form->input('trackingNumber');											
										}
									?>
								</td>
							</tr>

							<tr>
								<!-- <th class="active col-md-3"> Zip Code </th> -->
								<!-- <td width="20%" align="center"> Invoice Number </td> -->
								<td> 
									<!-- <input type="text" size='35' name="invoiceNumber" id="invoiceNumber" />  -->
									<?php 
										if( isset($datas['OrderTracking']['id']) ){
											echo $this->Form->input('invoiceNumber', array('default' => $datas['OrderTracking']['invoice_number']));
										}
										else{
											echo $this->Form->input('invoiceNumber');
										}
									?>
								</td>
							</tr>

							<tr>
								<!-- <th class="active col-md-3"> UPS Service Price </th> -->
								<!-- <td width="20%" align="center"> Ship Date </td> -->
								<td> 
									<!-- <input type="text" size='35' name="shipDate" id="shipDate" />  -->
									<?php 
										if( isset($datas['OrderTracking']['id']) ){
											echo $this->Form->input('shipDate', array('default' => date('F j, Y', strtotime($datas['OrderTracking']['shipdate']))));
										}
										else{
											/*echo $this->Form->input('shipDate', array('default' => date('F j, Y', strtotime('now'))));*/
											echo $this->Form->input('shipDate', array('default' => date('F j, Y', strtotime($datas['Order']['added']))));
										}
									?>
								</td>
							</tr>

							<tr>
								<!-- <th class="active col-md-3"> UPS Service Name </th> -->
								<!-- <td width="20%" align="center"> Total Invoice </td> -->
								<td> 
									<!-- <input type="text" size='35' name="totalInvoice" id="totalInvoice" /> --> 
									<?php 
										if( isset($datas['OrderTracking']['id']) ){
											echo $this->Form->input('totalInvoice', array('default' => $datas['OrderTracking']['total_invoice']));
										}
										else{
											$subtotal_amount = $datas['Payment']['charge'] - $datas['Shipping']['upsServicePrice'];
											$totalAmount = ($subtotal_amount + $datas['Shipping']['upsServicePrice']);
											/*$totalAmount = ($datas['Payment']['charge'] + $datas['Shipping']['upsServicePrice']);*/ 
											/*echo "$".number_format($totalAmount,2,'.', ' ,');*/
											echo $this->Form->input('totalInvoice', array('default' => number_format($totalAmount,2,'.', ' ,')));
										}
									?>
								</td>
							</tr>

							<tr>
								<!-- <th class="active col-md-3"> Transaction Date </th> -->
								<!-- <td width="20%" align="center"> Upload Invoice </td> -->
								<td> 
									<!-- <input type="text" size='35' name="uploadInvoice" id="uploadInvoice" />  -->
									<?php
										if( isset($datas['OrderTracking']['id']) ){
											echo $this->Form->file('invoice_file', array('default' => $datas['OrderTracking']['attached_file'], 'type' => 'file'));
											echo 'Attached: <a href="'.UPLOADED_FILE_ATTACHMENTS.$datas['OrderTracking']['attached_file'].'" target="_blank">'.$datas['OrderTracking']['attached_file'].'</a>';
										}
										else{
											echo $this->Form->file('invoice_file');
										}
									?>
								</td>
							</tr>

							<tr>
								<!-- <th class="active col-md-3"> Transaction Date </th> -->
								<!-- <td width="20%" align="center"> Comment </td> -->
								<td> 
									<!-- <textarea id="comment" name="comment" style="width:400px;height:100px;"></textarea>  -->
									<?php 
										if( isset( $datas['OrderTracking']['id'] ) ){
											echo $this->Form->input('comment', array('default' => $datas['OrderTracking']['comment'], 'rows' => 3));
										}
										else{
											echo $this->Form->input('comment', array('rows' => 3));
										}
									?>
								</td>
							</tr>	

						</table>
						<?php
							if( isset( $datas['OrderTracking']['id'] ) ){
						?>
							<a href="<?php echo Router::url('/',true)."orders/send_order_information/".$datas['OrderTracking']['id'];?>" class="btn btn-default btn-md pull" role="button">
						  		<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Send Email
							</a>
						<?php
							}
							else{
						?>
								<a disabled="disabled "href="#" class="btn btn-default btn-md pull" role="button">
							  		<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Send Email
								</a>
						<?php
							}
						?>

					<?php echo $this->Form->end('Submit', array('class' => 'btn btn-default btn-md pull'));?>
					
					


					<!-- </form>	 -->

				</div>				

			</div>		
		</div>
		<br />
		<br />
		<!-- end of Tracking Information -->


		<div class="row">

			<div class="col-md-12">

				<a href="<?php echo Router::url('/',true)."orders/export_to_windoi/".$this->request->params['pass'][0].'.xls';?>" class="btn btn-primary btn-md " role="button">
				  	Export to Windoi &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

				<a href="<?php echo Router::url('/',true)."orders/export_to_pdf/".$this->request->params['pass'][0].'.pdf';?>" class="btn btn-primary btn-md " role="button">
				  	Export to PDF &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

			</div>

		</div>


		<!-- <div class="row">

			<div class="col-md-12 ">


				<a href="#" class="btn btn-primary btn-md" role="button">
				  	Export to Windoi &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

				<a href="#" class="btn btn-primary btn-md" role="button">
				  	Export to PDF &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>				

				<a href="#" class="btn btn-primary btn-md" role="button">
				  	Proceed to Order &nbsp; <span class="glyphicon glyphicon glyphicon-arrow-right"></span>
				</a>			

			</div>

		</div> -->

		<div class="row">
			<div class="col-md-12">
				<div id='city_id'>
				</div>
			</div>
		</div>

	</div>


	<?php
		$update_url = Router::url(array('controller'=>'orders','action'=>'update_order'),true);
	?>

</div>
<script type="text/javascript">
	
	(function($){
		$('select#order_mode').on('change', function(){
			/*alert( $(this).val() );*/
			var order_mode = $(this).val();
			var order_id = "<?php echo $datas['Order']['id']; ?>";
			/*console.log( order_id );*/
			$.ajax({
			    type: 'post',
			    url: "<?=$this->Html->url(array('controller' => 'orders','action' => 'update_order'),true);?>",
			   /* data:"data=" + result + ,*/
			   	data: {mode: order_mode, oid: order_id},
			        success: function(data){
			            $('td#td_order_mode').html( order_mode );
			            alert( data );
			        }
		    })
		});
	}(jQuery));

</script>
