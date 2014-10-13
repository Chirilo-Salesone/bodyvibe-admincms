<div class="row">




	<div class="col-md-12">

		<div class="row">

			<div class="col-md-12">

				<a href="<?php echo $this->request->referer();?>" class="btn btn-default btn-md pull" role="button">
			  		<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
				</a>			

				<hr/>

				<a href="#" class="btn btn-primary btn-md " role="button">
				  	Export to Windoi &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>

				<a href="#" class="btn btn-primary btn-md " role="button">
				  	Export to PDF &nbsp; <span class="glyphicon glyphicon glyphicon-export"></span>
				</a>


				<a href="#" class="btn btn-primary btn-md " role="button">
				  	Proceed to Order &nbsp; <span class="glyphicon glyphicon glyphicon-arrow-right"></span>
				</a>			

			</div>

		</div>

	<br/>	

		<!-- table wrapper -->
		<div class="table-responsive">

			<table class="table  table-bordered table-condensed">
			
				<tr class="active">
					<th> Customer Name </th>
					<th> Date Added </th>
					<th> Date Modified </th>
					<th> Phone No </th>
				</tr>	

				<tbody>
					<tr>
					<td> 
						<?php 
							 echo $customerName = $this->request->data['Customer']['ship_fname']." 
								  ".$this->request->data['Customer']['ship_lname'];
						?> 
					</td>
					<td> <?php echo $this->request->data['Cart']['added']?> </td>
					<td> <?php echo $this->request->data['Cart']['modified']?> </td>
					<td> <?php echo $this->request->data['Customer']['ship_phone']?> </td>
					</tr>
				</tbody>
			</table>	

		</div>	
<?php /*
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
										<td> <?php echo $this->request->data['Customer']['ship_company']?> </td>
									</tr>	

								</table>	

							</div>				

				</div>				



		</div>
*/ ?>		
		
		<h2 class="page-header"> Product Details </h2>


		<div class="row">

			<div class="col-md-12">

				<a href="#" class="btn btn-danger btn-md" role="button">
				  	Delete All Items &nbsp; <span class="glyphicon glyphicon glyphicon-trash"></span>
				</a>

			</div>

		</div>
		<br/>

<?php /*
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
						
						<td> <?php echo $CartProduct['Product']['image_name']; ?> </td>
						<td> <?php echo $CartProduct['Product']['number']; ?> </td>						
						<td> <?php echo $CartProduct['Color']['name']; ?> </td>						
						<td> <?php echo $CartProduct['CartsProducts']['qty']. ' pcs'; ?> </td>
						<td><?php echo '$'.$CartProduct['CartsProducts']['price']; ?></td>
						<td><?php echo $CartProduct['Product']['discount_value'].'%'; ?></td>
						<td> 
							<?php 
								$productAmount = ($CartProduct['CartsProducts']['qty'] * $CartProduct['CartsProducts']['price']); 
								echo "$".number_format($productAmount,2,'.',0);
							?> 
						</td>
					</tr>

					<?php } ?>
				</tbody>

			</table>
		</div>
		<!-- table wrapper -->		


*/ ?>
		<div class="row">

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

		</div>



	</div>

</div>
