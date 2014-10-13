<div class="row">


	<div class="col-md-12">

		<div class="row">

			<div class="col-md-12">

				<a href="<?php echo $this->request->referer();?>" class="btn btn-default btn-md pull" role="button">
			  		<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
				</a>			

				<hr/>


				<!-- <a href="<?php //echo Router::url('/',true)."carts/edit/".$this->request->params['pass'][0].'.xls';?>" class="btn btn-primary btn-md " role="button">
				  	Export to Windoi &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a> -->
				<a href="<?php echo Router::url('/',true)."carts/export_to_windoi/".$this->request->data['Cart']['id'];?>" class="btn btn-primary btn-md " role="button">
				  	Export to Windoi &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

				<!-- <a href="<?php //echo Router::url('/',true)."carts/edit/".$this->request->params['pass'][0].'.pdf';?>" class="btn btn-primary btn-md " role="button">
				  	Export to PDF &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a> -->

				<a href="<?php echo Router::url('/',true)."carts/export_to_pdf/".$this->request->params['pass'][0].'.pdf';?>" class="btn btn-primary btn-md " role="button">
				  	Export to PDF &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

				<!-- <a href="<?php //echo Router::url('/',true)."carts/export_to_windoi_images/".$this->request->data['Cart']['id'];?>" class="btn btn-primary btn-md " role="button">
				  	Export to Windoi with Images &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a> -->

				<?php /* commented out - sep 27, 2014 - currently not used */
				/*<a href="#" class="btn btn-primary btn-md " role="button">
				  	Proceed to Order &nbsp; <span class="glyphicon glyphicon glyphicon-arrow-right"></span>
				</a>*/
				?>

			</div>

		</div>

	<br/>	

		<!-- table wrapper -->
		<div class="table-responsive">

			<table class="table  table-bordered table-condensed">
			
				<tr class="active">
					<th> Customer Name </th>
					<th> Email </th>
					<th> Added </th>
					<th> Modified </th>
					<th> Phone No </th>
				</tr>	

				<tbody>
					<td> 
						<?php 
							 echo $customerName = $this->request->data['Customer']['ship_fname']." ".$this->request->data['Customer']['ship_lname'];
						?> 
					</td>
					<td> <?php echo $this->request->data['Customer']['email']?> </td>
					<td> <?php echo date_format( new DateTime($this->request->data['Cart']['added']),'M d, Y H:i:s')?> </td>
					<td> 
						<?php 
							/*echo date_format( new DateTime($this->request->data['Cart']['modified']),'M d, Y H:i:s');*/
							if( strtotime($this->request->data['Cart']['modified']) ){
								echo date_format( new DateTime($this->request->data['Cart']['modified']),'M d, Y H:i:s');
							}
							else{
								echo date_format( new DateTime($this->request->data['Cart']['added']),'M d, Y H:i:s');
							}
						?> 
					</td>
					<td> <?php echo $this->request->data['Customer']['ship_phone']?> </td>
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
										<td> <?php echo $this->request->data['Customer']['bill_company']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Street </th>
										<td> <?php echo $this->request->data['Customer']['bill_street']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> City </th>
										<td> <?php echo $this->request->data['Customer']['bill_city']?></td>
									</tr>	

									<tr>
										<th class="active col-md-3"> State </th>
										<td> <?php echo $this->request->data['Customer']['bill_state']?> </td>
									</tr>	

									<tr>
										<th class="active col-md-3"> Country </th>
										<td> <?php echo $this->request->data['Customer']['bill_country']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Zip </th>
										<td> <?php echo $this->request->data['Customer']['bill_postcode']?> </td>
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
										<td> <?php echo $this->request->data['Customer']['ship_company']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Street </th>
										<td> <?php echo $this->request->data['Customer']['ship_street']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> City </th>
										<td> <?php echo $this->request->data['Customer']['ship_city']?></td>
									</tr>	

									<tr>
										<th class="active col-md-3"> State </th>
										<td> <?php echo $this->request->data['Customer']['ship_state']?> </td>
									</tr>	

									<tr>
										<th class="active col-md-3"> Country </th>
										<td> <?php echo $this->request->data['Customer']['ship_country']?> </td>
									</tr>	
									<tr>
										<th class="active col-md-3"> Zip </th>
										<td> <?php echo $this->request->data['Customer']['ship_postcode']?> </td>
									</tr>										


								</table>	

							</div>				

				</div>	

				<div class="col-md-6"> 

							<h1 class="page-header"> Cart Summary Amount </h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed custom-admin-listing">
								
									<tr>
										<th class="active col-md-3"> Total Amount </th>
										<td> $ <?php echo number_format($this->request->data['Cart']['shoptotal'], 2, '.', ' ,')?> </td>
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
								if( isset($this->request->data['Customer']['salesrep_id']) && $this->request->data['Customer']['salesrep_id'] != 0 ){
							?>
									<tr>
										<th class="active col-md-3"> Sales Representative </th>
										<td> <?php echo ucfirst( $salesreps[ $this->request->data['Customer']['salesrep_id'] ] );?> </td>
									</tr>
							<?php
								}
								elseif( isset($this->request->data['Customer']['salesrep']) && $this->request->data['Customer']['salesrep'] != '' ){
							?>
									<tr>
										<th class="active col-md-3"> Sales Representative </th>
										<td> <?php echo ucfirst( $this->request->data['Customer']['salesrep'] );?> </td>
									</tr>
							<?php
								}
								else{
							?>
									<tr>
										<th class="active col-md-3"> Sales Representative </th>
										<td> User has no Sales Representative </td>
									</tr>
							<?
								}
							?>
								

						</table>	

					</div>				

				</div>	
				<?php /*end of sales rep*/ ?>

				<?php 
					/* for Customer's Coupon */
					if( $this->request->data['Cart']['coupon_id'] != 0 ){
				?>
				<div class="col-md-6"> 

							<h1 class="page-header"> Coupon Details</h1>
							<div class="table-responsive">

								<table class="table  table-bordered table-condensed custom-admin-listing">
								
									<tr>
										<th class="active col-md-3"> Coupon Name </th>
										<td><?php echo $this->request->data['Coupon']['name']?> </td>
									</tr>	

									<tr>
										<th class="active col-md-3"> Coupon Details </th>
										<td><?php echo $this->request->data['Coupon']['details']?> </td>
									</tr>

									<tr>
										<th class="active col-md-3"> Promo Code </th>
										<td><?php echo $this->request->data['Coupon']['promocode']?> </td>
									</tr>

									<tr>
										<th class="active col-md-3"> Discount Rate </th>
										<td> $ <?php echo number_format($this->request->data['Coupon']['discountrate'], 2, '.', ' ,')?> </td>
									</tr>

								</table>	

							</div>				

				</div>		
				<?php 
					}
					/* end for Customer's Coupon */
				?>	



		</div>

		<?php /* Package Widget */ ?>
		<h2 class="page-header"> Package Details</h2>
		<div class="row">
			<div class="col-md-6"> 

						<div class="table-responsive">

							<table class="table  table-bordered table-condensed custom-admin-listing">
							
								<tr>
									<th class="active col-md-3"> Package Cost </th>
									<td> $ <?php echo number_format($this->request->data['Package']['cost'], 2, '.', ' ,')?> </td>
								</tr>	

							</table>	

						</div>				

			</div>		
		</div>
		<?php /* end of Package Widget */ ?>
		
		<h2 class="page-header"> Product Details </h2>


		<div class="row">

			<div class="col-md-12">

				<a href="<?php echo Router::url('/',true)."carts/delete_all_items/".$this->request->params['pass'][0];?>" class="btn btn-danger btn-md" role="button">
				  	Delete All Items &nbsp; <span class="glyphicon glyphicon glyphicon-trash"></span>
				</a>

			</div>

		</div>
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
				<?php foreach($carts_products as $CartProduct){ ?>
					<tr>
						<td width="104"> 
							<?php
								$image_path = PRODUCTS_IMAGES_THUMBS.$CartProduct['Product']['image_name'].'.jpg';
								if( @getimagesize($image_path) ){
							?>
									<img src="<?php echo PRODUCTS_IMAGES_THUMBS.$CartProduct['Product']['image_name']; ?>.jpg" height="104" width="104" style="border: 1px solid #000;" />
							<?php
								}
								else{
							?>
									<img src="<?php echo PRODUCTS_IMAGES_THUMBS ?>notavailable.jpg" height="104" width="104" style="border: 1px solid #000;" />
							<?php
								}
							?>
							  
						</td>
						<td> <?php echo $CartProduct['Product']['number']; ?> </td>						
						<td> <?php echo $CartProduct['Color']['name']; ?> </td>						
						<td> <?php echo $CartProduct['CartsProducts']['qty']. ' pcs'; ?> </td>

						<?php
							/* 
							* used for product discounted price and product discount value
							* based on the calculation by Zach Tanzinco - sep 24, 2014 
							*/
							$discount_value_for_each_product = '';	/* product discount value */
							$discounted_price_for_each_product = 0;
							$total_calculated_amount_for_each_product = 0;
							if( $CartProduct['CartsProducts']['qty'] <= 2 ){	/* 1-2 products */
								
								/* check if product has discount_value */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $CartProduct['Product']['discount_value'].'%';
								}
								elseif( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '0.00%';
								}
								
								/* For special discount_values (e.g. 75%) */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 75.00 ){
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.75), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}
								else{
									$discounted_price_for_each_product = $CartProduct['Product']['price'];
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}
								
							}
							elseif( $CartProduct['CartsProducts']['qty'] == 3 || $CartProduct['CartsProducts']['qty'] <= 5 ){
								
								/* check if product has discount_value - for discount_Value display on product details */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $CartProduct['Product']['discount_value'].'%';
								}
								elseif( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '15.00%';
								}

								/* For special discount_values (e.g. 75%) */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 75.00 ){
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.75), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}
								else{
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.15), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}

								
							}
							elseif( $CartProduct['CartsProducts']['qty'] == 6 || $CartProduct['CartsProducts']['qty'] <= 11 ){
								
								/* check if product has discount_value */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $CartProduct['Product']['discount_value'].'%';
								}
								elseif( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '25.00%';
								}

								/* For special discount_values (e.g. 75%) */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 75.00 ){
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.75), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}
								else{
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.25), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}

								
							}
							elseif( $CartProduct['CartsProducts']['qty'] >= 12 ){
								
								/* check if product has discount_value */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] != 0.00 ){
									$discount_value_for_each_product = $CartProduct['Product']['discount_value'].'%';
								}
								elseif( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 0.00 ){
									$discount_value_for_each_product = '35.00%';
								}

								/* For special discount_values (e.g. 75%) */
								if( isset( $CartProduct['Product']['discount_value'] ) && $CartProduct['Product']['discount_value'] == 75.00 ){
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.75), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}
								else{
									$the_discount_value = number_format( ($CartProduct['Product']['price'] * 0.35), 2, '.', ', ');
									$discounted_price_for_each_product = $CartProduct['Product']['price'] - $the_discount_value;
									$total_calculated_amount_for_each_product = $CartProduct['CartsProducts']['qty'] * $discounted_price_for_each_product;
								}

								
							}
						/* end */
						?>


						<td>
							<?php 
								/*echo '$'.number_format($CartProduct['CartsProducts']['price'], 2, '.', ' ,');*/ 
								echo '$'.number_format($discounted_price_for_each_product, 2, '.', ' ,');
							?>
						</td>
						<td>
							<?php 
								/*echo $CartProduct['Product']['discount_value'].'%';*/
								echo $discount_value_for_each_product;
							?>
						</td>
						<td> 
							<?php 
								/*$productAmount = ($CartProduct['CartsProducts']['qty'] * $CartProduct['CartsProducts']['price']); 
								echo "$".number_format($productAmount,2,'.', ' ,');*/
								echo "$".number_format($total_calculated_amount_for_each_product,2,'.', ' ,');
							?> 
						</td>
					</tr>

					<?php } ?>
				</tbody>

			</table>
		</div>
		<!-- table wrapper -->		


		<?php 
			/* Current Shipping Information */ 
			/*if( isset($this->request->data['Shipping']['id']) ){*/
		?>
		<!--<?php/* <h2 class="page-header"> Current Shipping Information</h2>
		<div class="row">
			<div class="col-md-6"> 

				<div class="table-responsive">

					<table class="table  table-bordered table-condensed custom-admin-listing">
					
						<tr>
							<th class="active col-md-3"> Country </th>
							<td><?php //echo $this->request->data['Shipping']['country']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> Zip Code </th>
							<td><?php //echo $this->request->data['Shipping']['zip']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> UPS Service Price </th>
							<td> $ <?php //echo number_format($this->request->data['Shipping']['upsServicePrice'], 2, '.', ' ,')?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> UPS Service Name </th>
							<td><?php //echo $this->request->data['Shipping']['upsServiceName']?> </td>
						</tr>

						<tr>
							<th class="active col-md-3"> Transaction Date </th>
							<td> <?php// echo date('M d, Y H:i:s',strtotime($this->request->data['Shipping']['date_transacted']))?> </td>
						</tr>	

					</table>	

				</div>				

			</div>		
		</div> */?>-->
		<?php 
			/*}*/
			/* end of Current Shipping Information */ 
		?>



		<div class="row">

			<div class="col-md-12 ">


				<a href="<?php echo Router::url('/',true)."carts/export_to_windoi/".$this->request->data['Cart']['id'];?>" class="btn btn-primary btn-md " role="button">
				  	Export to Windoi &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>


				<a href="<?php echo Router::url('/',true)."carts/export_to_pdf/".$this->request->params['pass'][0].'.pdf';?>" class="btn btn-primary btn-md " role="button">
				  	Export to PDF &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

				<?php /* commented out - sep 27, 2014 - currently not used */
				/*<a href="#" class="btn btn-primary btn-md " role="button">
				  	Proceed to Order &nbsp; <span class="glyphicon glyphicon glyphicon-arrow-right"></span>
				</a>*/
				?>		
			

			</div>

		</div>



	</div>

</div>
