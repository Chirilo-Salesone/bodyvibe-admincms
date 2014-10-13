<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Body Part
		</a>

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
						<th>ID</th>
						<th> Name </th>
						<th> Valueurl </th>
						<th> Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($bodyparts as $bodypart){ ?>
							<tr>
								<td><?php echo $bodypart['Bodypart']['id']; ?></td>
								<td><?php echo $bodypart['Bodypart']['name']; ?></td>
								<td><?php echo $bodypart['Bodypart']['valueurl'];?></td>
								<td><?php echo $bodypart['Bodypart']['status'];?></td>
								<td class="actions">
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $bodypart['Bodypart']['id'])); ?>
									<?php 
										if($bodypart['Bodypart']['status']=="active"){
											echo $this->Form->postLink(__('Deactivate'), array('action' => 'deactivate', $bodypart['Bodypart']['id']), null, __('Are you sure you want to Deactivate # %s?', $bodypart['Bodypart']['name'])); 
										}
										else{
											echo $this->Form->postLink(__('Activate'), array('action' => 'activate', $bodypart['Bodypart']['id']), null, __('Are you sure you want to Activate # %s?', $bodypart['Bodypart']['name'])); 

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
