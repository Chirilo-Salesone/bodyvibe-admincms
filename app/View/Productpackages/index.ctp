<div class="row">
	<div class="col-md-12">

		<br/>


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th> ID </th>
						<th> Cost </th>
						<th> Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($productpackages as $productpackage){ ?>
							<tr>
								<td><?php echo $productpackage['Productpackage']['id']; ?></td>
								<td>$<?php echo $productpackage['Productpackage']['cost'];?></td>
								<td><?php echo $productpackage['Productpackage']['status'];?></td>
								<td class="actions">
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $productpackage['Productpackage']['id'])); ?>
									<?php 
										if($productpackage['Productpackage']['status']=="active"){
											echo $this->Form->postLink(__('Deactivate'), array('action' => 'deactivate', $productpackage['Productpackage']['id']), null, __('Are you sure you want to Deactivate # %s?', $productpackage['Productpackage']['id'])); 
										}
										else{
											echo $this->Form->postLink(__('Activate'), array('action' => 'activate', $productpackage['Productpackage']['id']), null, __('Are you sure you want to Activate # %s?', $productpackage['Productpackage']['id'])); 

										}
									?>
								</td>
							</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->

	


	</div>

</div>
