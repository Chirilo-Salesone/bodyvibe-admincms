<div class="row">
	<div class="col-md-12">

		<!-- pagination -->
			<div class="paging">
				<?php

					echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ' | '));
					echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));

				?>
			</div>
		<!-- pagination -->
		<br/>


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
					<tr>
							<th> ID </th>
							<th><?php echo $this->Paginator->sort('email'); ?></th>
							<th><?php echo $this->Paginator->sort('ship_fname','First Name'); ?></th>
							<th><?php echo $this->Paginator->sort('ship_lname','Last Name'); ?></th>
							<th><?php echo $this->Paginator->sort('ship_company','Company'); ?></th>
							<th><?php echo $this->Paginator->sort('ship_street','Address'); ?></th>
							<th><?php echo $this->Paginator->sort('added',' Date Added ');?></th>	
							<th> Mode </th>
							<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					<?php foreach ($customers as $customer): ?>
					<tr>
						<td><?php echo $customer['Customer']['id']; ?></td>
						<td><?php echo $customer['Customer']['email']; ?></td>
						<td><?php echo ucfirst($customer['Customer']['ship_fname']); ?></td>
						<td><?php echo ucfirst($customer['Customer']['ship_lname']); ?></td>
						<td><?php echo $customer['Customer']['ship_company']; ?></td>
						<td><?php echo $customer['Customer']['ship_street']; ?></td>
						<td><?php echo date('F d, Y H:i:s a',strtotime($customer['Customer']['added']));?></td>
						<td><?php echo $customer['Customer']['mode']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $customer['Customer']['id'])); ?>
							<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $customer['Customer']['id']), null, __('Are you sure you want to delete # %s?', $customer['Customer']['id'])); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>

			</div>	


		<!-- pagination -->
			<div class="paging">
				<?php

					echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ' | '));
					echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));

				?>
			</div>
		<!-- pagination -->
		<br/>
		

	</div>

</div>	

