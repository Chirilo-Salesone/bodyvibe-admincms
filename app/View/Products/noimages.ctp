<div class="row">
	<div class="col-md-12">



			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th> ID </th>
						<th> Number </th>
						<th> Image Name </th>
						<th> Date Added </th>
					</thead>	

					<tbody>
					<?php foreach($products as $product){ ?>
							<tr>
								<td><?php echo $product['Product']['id']; ?></td>
								<td><?php echo $product['Product']['number']; ?></td>
								<td><?php echo $product['Product']['image_name'];?></td>
								<td><?php echo date_format(new DateTime($product['Product']['added']),'M d, Y H:i:s a');?></td>
								
							</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->
		


	</div>

</div>
