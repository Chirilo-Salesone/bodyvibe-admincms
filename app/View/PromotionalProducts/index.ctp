<div class="row">
<div class="col-md-12">
			<!-- <p><?php /*echo $this->Html->link("Add Promotional Product", array('action' => 'add'));*/ ?></p> -->
			<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
				<span class="glyphicon glyphicon glyphicon-plus"></span> Add Promotional Product
			</a>
			<br />
			<br />
			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
							<th> ID</th>
							<th> Title </th>
							<th> Description </th>
							<th> Link </th>
							<th> Added </th>
							<th> Status </th>
							<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($promotionalProducts as $promotionalProduct){ ?>

						<tr>
							<td><?php echo $promotionalProduct['PromotionalProduct']['id']; ?>&nbsp;</td>
							<td><?php echo $promotionalProduct['PromotionalProduct']['title']; ?>&nbsp;</td>
							<td><?php echo $promotionalProduct['PromotionalProduct']['description']; ?>&nbsp;</td>
							<td><?php echo $promotionalProduct['PromotionalProduct']['link']; ?>&nbsp;</td>
							<td><?php echo date_format( new DateTime($promotionalProduct['PromotionalProduct']['date_added']),'M d, Y H:i:s'); ?> </td>
							<td><?php echo $promotionalProduct['PromotionalProduct']['status']; ?>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $promotionalProduct['PromotionalProduct']['id'])); ?>
								<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $promotionalProduct['PromotionalProduct']['id']), null, __('Are you sure you want to delete # %s?', $promotionalProduct['PromotionalProduct']['id'])); ?>
							</td>
						</tr>

					<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->



</div>
</div>
