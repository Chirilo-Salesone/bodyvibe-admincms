<div class="row">
<div class="col-md-12">

		<!-- pagination -->
			<div class="paging">
				<?php

					$pagination = $this->Paginator->numbers(array('separator' => ' | '));

					if( $pagination!=""){

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
						
						<th> Name</th>
						<th> Code</th>
						<th style="width: 100px"> Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($colors as $Color){ ?>
						<tr>
							<td><?php echo $Color['Color']['name'];?></td>
							<td><?php echo $Color['Color']['code']; ?></td>
							<td><?php echo $Color['Color']['status'];?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $Color['Color']['id'])); ?>
								<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $Color['Color']['id']), null, __('Are you sure you want to delete # %s?', $Color['Color']['id'])); ?>
							</td>
						</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->

	

</div>
</div>
