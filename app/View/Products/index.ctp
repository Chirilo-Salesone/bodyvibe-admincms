<div class="row">
	<div class="col-md-12">


		<!-- pagination -->
			<div class="paging">
				<?php

					$pagination = $this->Paginator->numbers(array('separator' => ' | '));

					if($pagination!=""){

						echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
						echo $pagination;
						echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));

					}

				?>
			</div>
		<!-- pagination -->
		<br/>


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo "Number"; ?></th>
						<th><?php echo "Image name"; ?></th>
						<th><?php echo "Price"; ?></th>
						<th><?php echo "Discount Chart"; ?></th>
						<th><?php echo "Discount Value"; ?></th>
						<th><?php echo "Promocode"; ?></th>
						<th><?php echo "Avail Qty"; ?></th>
						<th><?php echo "Packaging"; ?></th>
						<th><?php echo $this->Paginator->sort('status'); ?></th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($products as $product){ ?>
							<tr>
								<td><?php echo $product['Product']['id']; ?></td>
								<td><?php echo $product['Product']['number']; ?></td>
								<td><?php echo $product['Product']['image_name'];?></td>
								<td><?php echo "$".$product['Product']['price']; ?></td>
								<td><?php echo $product['Product']['discount_chart']; ?></td>
								<td><?php echo $product['Product']['discount_value']; ?></td>
								<td><?php echo $product['Product']['promocode'];?></td>
								<td><?php echo $product['Product']['avail_qty'];?></td>
								<td><?php echo $product['Product']['packaging'];?></td>
								<td><?php echo $product['Product']['status'];?></td>
								<td class="actions">
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $product['Product']['id'])); ?>
									<?php 
										if($product['Product']['status']=="active"){
											echo $this->Form->postLink(__('Deactivate'), array('action' => 'deactivate', $product['Product']['id']), null, __('Are you sure you want to Deactivate # %s?', $product['Product']['number'])); 
										}
										else{
											echo $this->Form->postLink(__('Activate'), array('action' => 'activate', $product['Product']['id']), null, __('Are you sure you want to Activate # %s?', $product['Product']['number'])); 

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
