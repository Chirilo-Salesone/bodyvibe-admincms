<div class="row">
<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Subcategory
		</a>
		<br />
		<br />

		<?php /*pagination*/ ?>
			<div class="paging">
				<?php



					$pagination = $this->Paginator->numbers(array('separator' => ' | '));

					if($pagination!=""){

						echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
						echo $pagination;
						echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));

					}

				?>
			</div>
		<?php /*pagination*/ ?>
		<br/>


			<?php /*table wrapper*/ ?>
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
					
						<th><?php echo $this->Paginator->sort('name','Name'); ?></th>
						<th style="width: 120px"> Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($subcategories as $Subcategory){ ?>
						<tr>
							<td><?php echo $Subcategory['Subcategory']['name']; ?></td>
						
							<td><?php echo $Subcategory['Subcategory']['status'];?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $Subcategory['Subcategory']['id'])); ?>
								<?php /*echo $this->Form->postLink('Delete', array('action' => 'delete', $Subcategory['Subcategory']['id']), null, __('Are you sure you want to delete # %s?', $Subcategory['Subcategory']['id']));*/ ?>

								<?php 

									if($Subcategory['Subcategory']['status']=="active"){
										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $Subcategory['Subcategory']['id']), null, __('Are you sure you want to Deactivate # %s?', $Subcategory['Subcategory']['name'])); 
									}
									else{
										
										echo $this->Form->postLink('Activate', array('action' => 'activate', $Subcategory['Subcategory']['id']), null, __('Are you sure you want to Activate # %s?', $Subcategory['Subcategory']['name'])); 

									}
								?>
							</td>
						</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<?php /*table wrapper*/ ?>

</div>
</div>
