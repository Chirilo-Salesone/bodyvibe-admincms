<div class="row">
<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Category
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
						<th style="width: 150px"><?php echo $this->Paginator->sort('name','Name'); ?></th>
						<th>Description </th>
						<th style="width: 130px">Group </th>
						<!-- <th style="width: 150px"><?php /*echo $this->Paginator->sort('url','Url');*/ ?> </th> -->
						<th>Status </th>
						<th class="row-option">Options</th>
					</thead>	

				
					<tbody>
					<?php foreach($categories as $category){ ?>
						<tr>
							
							<td><?php echo $category['Category']['name']; ?></td>
							<td><?php echo $category['Category']['description'];?></td>
							<td>
								<?php 

									if( isset( $category['Category']['group_id'] ) ){
										echo $groups[ $category['Category']['group_id'] ];
									}
									else{
										echo '';
									}
									/*echo $category['Category']['group_id'];*/

								?>
							</td>
							<!-- <td><?php /*echo $category['Category']['categoryurl'];*/?></td> -->
							<td><?php echo $category['Category']['status'];?></td>
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $category['Category']['id'])); ?>
								<?php 

									if($category['Category']['status']=="active"){
										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $category['Category']['id']), null, __('Are you sure you want to Deactivate # %s?', $category['Category']['name'])); 
									}
									else{
										
										echo $this->Form->postLink('Activate', array('action' => 'activate', $category['Category']['id']), null, __('Are you sure you want to Activate # %s?', $category['Category']['name'])); 

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
