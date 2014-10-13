<div class="row">
<div class="col-md-12">


		<br/>


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
							<th>ID </th>
							<th>Name</th>
							<th>Short Name </th>
							<th>Display Type</th>
							<th>Url </th>
							<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($brands as $brand){ ?>

						<tr>
							<td><?php echo h($brand['Brand']['id']); ?>&nbsp;</td>
							<td><?php echo h($brand['Brand']['name']); ?>&nbsp;</td>
							<td><?php echo h($brand['Brand']['short_name']); ?>&nbsp;</td>
							<td><?php echo h($brand['Brand']['display_type']); ?>&nbsp;</td>
							<td><?php echo h($brand['Brand']['url']); ?>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $brand['Brand']['id'])); ?>
								
								<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $brand['Brand']['id']), null, __('Are you sure you want to delete # %s?', $brand['Brand']['id'])); ?>
							</td>
						</tr>

					<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->



</div>
</div>
