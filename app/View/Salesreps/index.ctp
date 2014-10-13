<div class="row">
	<div class="col-md-12">

			<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
				<span class="glyphicon glyphicon glyphicon-plus"></span> Add Sales Representative
			</a>
			<br />
			<br />

			<?php /*table wrapper*/ ?>
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
			
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Country</th>
						<th>Phone</th>
						<th>Phone Ext</th>
						<th>Status</th>
						<th>Options </th>
					</thead>	
					
					<tbody>
					<?php foreach ($salesreps as $salesrep): ?>
					<tr>
						<td><?php echo $salesrep['Salesrep']['id']; ?>&nbsp;</td>
						<td><?php echo $this->Form->postLink(ucfirst($salesrep['Salesrep']['name']), array('action' => 'view', $salesrep['Salesrep']['id'])); ?>&nbsp;</td>
						<td><?php echo $salesrep['Salesrep']['email']; ?>&nbsp;</td>
						<td><?php echo $salesrep['Country']['name']; ?>&nbsp;</td>
						<td><?php echo $salesrep['Salesrep']['phone']; ?>&nbsp;</td>
						<td><?php echo $salesrep['Salesrep']['phone_ext']; ?>&nbsp;</td>
						<td><?php echo $salesrep['Salesrep']['status']; ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salesrep['Salesrep']['id'])); ?>
							<?php 
								if($salesrep['Salesrep']['status']=="active"){

									echo $this->Form->postLink(__('Deactivate'), array('action' => 'deactivate', $salesrep['Salesrep']['id']), null, __('Are you sure you want to deactivate # %s?', $salesrep['Salesrep']['name'])); 
								}
								else{
									echo $this->Form->postLink(__('Activate'), array('action' => 'activate', $salesrep['Salesrep']['id']), null, __('Are you sure you want to activate # %s?', $salesrep['Salesrep']['name'])); 

								}

								?>
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>	
		
	</div>

</div>	

