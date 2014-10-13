<div class="row">
<div class="col-md-12">


		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Category Group
		</a>

		<br />
		<br />


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th> Id <?php /*echo $this->Paginator->sort('id');*/ ?></th>
						<th> Name <?php /*echo $this->Paginator->sort('name');*/ ?></th>
						<th> Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($categoryGroups as $categoryGroup){ ?>
						<tr>
							<td><?php echo $categoryGroup['CategoryGroup']['id']; ?></td>
							<td><?php echo $this->Form->postLink($categoryGroup['CategoryGroup']['name'], array('action' => 'view', $categoryGroup['CategoryGroup']['id'])); ?></td>
							<td><?php echo $categoryGroup['CategoryGroup']['status']; ?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $categoryGroup['CategoryGroup']['id'])); ?>

								<?php 

									if($categoryGroup['CategoryGroup']['status']=="active"){
										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $categoryGroup['CategoryGroup']['id']), null, __('Are you sure you want to Deactivate # %s?', $categoryGroup['CategoryGroup']['name'])); 
									}
									else{
										
										echo $this->Form->postLink('Activate', array('action' => 'activate', $categoryGroup['CategoryGroup']['id']), null, __('Are you sure you want to Activate # %s?', $categoryGroup['CategoryGroup']['name'])); 

									}
								?>

							</td>
						</tr>

						<?php } ?>

					</tbody>

				</table>



			</div>
			<!-- table wrapper -->



		<br/>			



</div>
</div>
