<div class="row">
	<div class="col-md-12">

	<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
		<span class="glyphicon glyphicon glyphicon-plus"></span> Add
	</a>

	<br/>
	<br/>


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th>ID</th>
						<th>Show</th>
						<th>Schedule</th>
						<th>Country</th>
						<th>Booth</th>
						<th>Added</th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($eventlist as $eventdetail){ ?>
							<tr>
								<td><?php echo $eventdetail['Event']['id']; ?></td>
								<td><?php echo $eventdetail['Event']['showname']; ?></td>
								<td><?php echo $eventdetail['Event']['schedule']; ?></td>
								<td><?php echo $eventdetail['Event']['country']; ?></td>
								<td><?php echo $eventdetail['Event']['booth_no']; ?></td>
								<td><?php echo date("F d, Y",strtotime($eventdetail['Event']['added'])); ?></td>
							
								<td class="actions">
									<?php 
										echo $this->Html->link('Edit', array('action' => 'edit', $eventdetail['Event']['id']));
										echo "&nbsp;";
 										echo $this->Form->postLink('Delete', array('action' => 'delete', $eventdetail['Event']['id']), null, __('Are you sure you want to delete this record?', $eventdetail['Event']['id'])); 
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

