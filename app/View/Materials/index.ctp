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
						<th>ID </th>
						<th>Name </th>
						<th>Description </th>
						<th>Url    </th>
						<th>Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($materials as $material){ ?>
						<tr>
							<td><?php echo $material['Material']['id']; ?></td>
							<td><?php echo $material['Material']['name'];?></td>
							<td><?php echo $material['Material']['description'];?></td>
							<td><?php echo $material['Material']['valueurl'];?></td>
							<td><?php echo $material['Material']['status'];?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $material['Material']['id'])); ?>
								<?php 

									if($material['Material']['status']=="active"){

										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $material['Material']['id']), null, __('Are you sure you want to Deactivate " %s " ?', $material['Material']['name'])); 
									}
									else{

										echo $this->Form->postLink('Activate', array('action' => 'activate', $material['Material']['id']), null, __('Are you sure you want to Activate " %s " ?', $material['Material']['name'])); 

									}
								?>
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
