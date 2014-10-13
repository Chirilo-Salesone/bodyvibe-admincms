<div class="row">

	<div class="col-md-12">

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


		
		<h2 class="page-header"> Product Details </h2>

		

		<!-- table wrapper -->
		<div class="table-responsive">


		</div>
		<!-- table wrapper -->		



	</div>

</div>
