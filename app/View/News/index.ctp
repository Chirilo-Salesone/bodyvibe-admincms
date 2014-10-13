<div class="row">
	<div class="col-md-12">

	<a href="<?php echo Router::url('/',true)."news/add"; ?>" class="btn btn-success btn-md pull" role="button">
		<span class="glyphicon glyphicon glyphicon-plus"></span> Add
	</a>

	<br/>
	<br/>


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th>ID</th>
						<th>Title</th>
						<th>Content</th>
						<th>Added</th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($newslist as $newdetail){ ?>
							<tr>
								<td><?php echo $newdetail['News']['id']; ?></td>
								<td><?php echo $newdetail['News']['title']; ?></td>
								<td><?php echo substr(strip_tags($newdetail['News']['content']),0,100);?></td>
								<td><?php echo date('F d, Y',strtotime($newdetail['News']['added'])); ?></td>
							
								<td class="actions">
									<?php 
										echo $this->Html->link('Edit', array('action' => 'edit', $newdetail['News']['id']));
										echo "&nbsp;";
 										echo $this->Form->postLink('Delete', array('action' => 'delete', $newdetail['News']['id']), null, __('Are you sure you want to delete this record?', $newdetail['News']['id'])); 
									?>
								</td>
							</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->

	

	</div>

</div>

