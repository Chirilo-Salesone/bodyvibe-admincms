<div class="row">
<div class="col-md-12">

	<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Catalogs
	</a>
	<br />
	<br />
	<?php
		echo '<pre>';
			print_r( $catalogs );
		echo '</pre>';

	?>


	<!-- table wrapper -->
	<div class="table-responsive">

		<table class="table table-hover table-bordered table-condensed custom-admin-listing">
		
			<thead class="active">
				<th> Name </th>
				<th> Status </th>
				<th>Added</th>
				<th class="row-option">Options</th>
			</thead>	

			<tbody>
			<?php foreach($catalogs as $catalog){ ?>
				<tr>
					<td> <?php echo $catalog['Catalog']['name']; ?> </td>
					<td> <?php echo $catalog['Catalog']['status']; ?> </td>
					<td> <?php echo date("F d, Y",strtotime($catalog['Catalog']['added']));?></td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('action' => 'edit', $catalog['Catalog']['id'])); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $catalog['Catalog']['id']), null, __('Are you sure you want to delete this catalog?', $catalog['Catalog']['id'])); ?>
					</td>
				</tr>

				<?php } ?>
			</tbody>

		</table>


	</div>
	<!-- table wrapper -->




</div>
</div>
