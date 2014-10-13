<div class="row">
<div class="col-md-12">


		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Product Search
		</a>
		<br />
		<br />
		

		<?php /*pagination*/ ?>
		<div class="paging">
			<?php

				$options_links = trim($this->Paginator->numbers(array('separator' => ' | ')));
				
				if($options_links!=""){
					echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
					echo $options_links;
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
							<th> Image Name </th>
							<th> Parameters </th>
							<th> Status </th>
							<th class="row-option"> Options </th>
					</thead>	

					<tbody>
					<?php foreach($productsearches as $productsearch){ ?>

						<tr>

							<td><?php echo $this->Form->postLink($productsearch['Product']['image_name'], array('action' => 'view', $productsearch['Productsearch']['id'])); ?></td>
							<td><?php echo h($productsearch['Productsearch']['parameters']); ?></td>
							<td><?php echo $productsearch['Productsearch']['status']; ?></td>
							<td class="actions">
								<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $productsearch['Productsearch']['id'])); ?>
								<?php 

									if($productsearch['Productsearch']['status']=="active"){
										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $productsearch['Productsearch']['id']), null, __('Are you sure you want to Deactivate # %s?', $productsearch['Productsearch']['id'])); 
									}
									else{
										
										echo $this->Form->postLink('Activate', array('action' => 'activate', $productsearch['Productsearch']['id']), null, __('Are you sure you want to Activate # %s?', $productsearch['Productsearch']['id'])); 

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
