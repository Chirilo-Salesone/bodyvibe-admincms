




<div class="row">

	<div class="col-md-8">
		<h4>WEBSITE SUMMARY </h4>
		<!-- table wrapper start -->
		<div class="table-responsive">
		<table class="table table-bordered table-condensed">
			
			<tr class="active">
				<th> &nbsp; </th>
				<th align="center"> TODAY </th>
				<th align="center"> THIS WEEK </th>
				<th align="center"> THIS MONTH </th>
			</tr>
			<tbody>
				<tr>
					<td> No. of Orders </td>
					<td align="center"> <?php echo $orders['count_daily_orders']?> </td>
					<td align="center"> <?php echo $orders['count_weekly_orders']?> </td>
					<td align="center"> <?php echo $orders['count_monthly_orders']?> </td>
				</tr>
				<tr>
					<td> Total amount of orders </td>
					<td align="center"> $<?php echo number_format($orders_amount['count_daily_orders_amount'], '2', '.', ', ');?> </td>
					<td align="center"> $<?php echo number_format($orders_amount['count_weekly_orders_amount'], '2', '.', ', ');?> </td>
					<td align="center"> $<?php echo number_format($orders_amount['count_monthly_orders_amount'], '2', '.', ', ');?> </td>
				</tr>
				<tr>
					<td>  Total new sign-ups </td>
					<td align="center"> <?php echo $customers['count_daily_signups']?> </td>
					<td align="center"> <?php echo $customers['count_weekly_signups']?> </td>
					<td align="center"> <?php echo $customers['count_monthly_signups']?> </td>
				</tr>
				<tr>
					<td>  Total no. of updated shopping carts </td>
					<td align="center"> <?php echo $carts['count_daily_carts_updated']?> </td>
					<td align="center"> <?php echo $carts['count_weekly_carts_updated']?> </td>
					<td align="center"> <?php echo $carts['count_monthly_carts_updated']?> </td>
				</tr>
				<tr>
					<td>  Shoppingcart reminder (Total no. of clicks) See detailed reports </td>
					<td align="center"> 0 </td>
					<td align="center"> 0 </td>
					<td align="center"> 0 </td>
				</tr>
				<tr>
					<td>  Shoppingcart reminder (Total no. of checkouts) See detailed reports </td>
					<td align="center"> 0 </td>
					<td align="center"> 0 </td>
					<td align="center"> 0 </td>
				</tr>
			</tbody>


		</table>
		</div>
		<!-- table wrapper end -->		
			
	</div>
	<div class="col-md-4">
		<h4>PRODUCTS SUMMARY </h4>
		<!-- table wrapper start -->
		<div class="table-responsive">
		<table class="table table-bordered table-condensed">

					<tr>
					    <th class="active" style="width: 40%"> No Descriptions </th>
					    <td> <?php echo '<strong>'.$products['without_descriptions'].'</strong>'; ?> items </td>
					</tr>
					<tr>
					    <th class="active"> Onsale Items </th>
					    <td> <?php echo '<strong>'.$products['count_onsale_items'].'</strong>'; ?> items </td>
					</tr>
					<tr>
					    <th class="active"> Newstyle Items </th>
					    <td> <?php echo '<strong>'.$products['count_newstyles_items'].'</strong>'; ?> items </td>
					</tr>
					<tr>
					    <th class="active"> Images </th>
					    <td> <?php echo '<strong>'.$products['count_image_items'].'</strong>'; ?> items </td>
					</tr>
					<tr>
					    <th class="active"> Active </th>
					    <td> <?php echo '<strong>'.$products['count_active_items'].'</strong>'; ?> items </td>
					</tr>

					<tr>
					    <th class="active"> Total </th>
					    <td> <?php echo '<strong>'.$products['count_items'].'</strong>'; ?> items </td>
					</tr>

			</table>
		</div>
		<!-- table wrapper end -->		
			
	</div>	


</div>

<!-- row -->
<div class="row">
	<div class="col-md-4">  
		<h4>ORDER SUMMARY</h4> 
		<!-- table wrapper start -->
		<div class="table-responsive">
			<table class="table table-bordered table-condensed">
				<tr class="active">
					<th>&nbsp;</th>
					<th> MONTH/YEAR </th>
					<th> ORDERS COUNT </th>
					<th> ORDERS AMOUNT </th>
				</tr>
				<tbody>
				<?php
					foreach($orders_amount_history as $month_year => $order_amount){
				?>
					<tr>
						<td><span class="glyphicon glyphicon glyphicon-star"></span></td>
						<td> <?php echo $month_year; ?> </td>
						<td> <?php echo $order_amount['total_monthly_orders']; ?> </td>
						<td> <?php echo '<strong>$ '.number_format($order_amount['total_monthly_orders_amount'], '2', '.', ', ').'</strong>'; ?> </td>
					</tr>	
				<?php
					}
				?>
				</tbody>
			</table>
		</div>
		<!-- table wrapper end -->

	</div>
	<div class="col-md-4"> 
		<h4> SIGN UPS SUMMARY</h4> 
		<!-- table wrapper start -->
		<div class="table-responsive">
			<table class="table table-bordered table-condensed">
				<tr class="active">
					<th> MONTH/YEAR </th>
					<th> TOTAL SIGN UPs </th>
				</tr>
				<tbody>
					<?php
						foreach($customers_history as $month_year => $customer){
					?>
						<tr>
							<td> <?php echo $month_year; ?> </td>
							<td> <?php echo $customer['total_monthly_signups']; ?> </td>
						</tr>
					<?php
						}
					?>	
			       
				</tbody>
			</table>
		</div>
		<!-- table wrapper end -->
	</div> 


	<div class="col-md-4"> 
		<h4> TOP SEARCH PARAMS </h4> 
		<!-- table wrapper start -->
		<div class="table-responsive">
			<table class="table table-bordered table-condensed">
				<tr class="active">
					<th> SEARCHES </th>
					<th> COUNT </th>
				</tr>
				<tbody>
					<?php foreach($search_logs as $log){ ?>
						<tr>
							<td> <?php echo $log['searchlogs']['param']; ?> </td>
							<td> <?php echo $log[0]['counter']; ?> </td>
						</tr>
					<?php } ?>	
				</tbody>
			</table>
		</div>
		<!-- table wrapper end -->
	</div>  
	
</div>
<!-- row -->

<!-- -->
<?php 
/* sep 23, 2014 - temporarily commented out */
/*
<div class="row">
		<div class="col-md-12">
			<h4>WEBSITE SUMMARY REMINDER </h4>
			<!-- table wrapper start -->
			<div class="table-responsive">
			<table class="table table-bordered table-condensed">
					
						<tr class="active">
						    <th> Name </th>
						    <th> Email Address </th>
						    <th> Contact Number </th>
						    <th> Comment </th>
						</tr>
					
					<tbody>
						<tr>
							<td> 1 </td><td> 1 </td>
							<td> 1 </td><td> 1 </td>
						</tr>	
						<tr>
							<td> 1 </td><td> 1 </td>
							<td> 1 </td><td> 1 </td>
						</tr>							

					</tbody>
				</table>
			</div>
			<!-- table wrapper end -->			
			
			
		</div>

</div> */
?>
<!-- -->




