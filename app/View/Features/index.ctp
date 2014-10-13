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
				
					<thead class="active">
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('description'); ?></th>
						<th><?php echo $this->Paginator->sort('status'); ?></th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($features as $feature){ ?>
						<tr>
							<td><?php echo $feature['Feature']['id']; ?></td>
							<td><?php echo $feature['Feature']['name'];?></td>
							<td><?php echo $feature['Feature']['description'];?></td>
							<td><?php echo $feature['Feature']['status'];?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $feature['Feature']['id'])); ?>
								<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $feature['Feature']['id']), null, __('Are you sure you want to delete # %s?', $feature['Feature']['id'])); ?>
							</td>
						</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->

		<!-- pagination -->
			<div class="paging">
				<?php

					echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ' | '));
					echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));

				?>
			</div>
		<!-- pagination -->

</div>
</div>
