<div class="row">
<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Fixed Shipping Rate
		</a>
		<br />
		<br />


			<!-- table wrapper -->
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th>ID</th>
						<th> Country Name </th>
						<th> Rate </th>
						
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($fixedshippingratecountries as $fixedshippingratecountry){ ?>
						<tr>
							<td><?php echo $fixedshippingratecountry['Fixedshippingratecountry']['id']; ?></td>
							<td><?php echo $countries[ $fixedshippingratecountry['Fixedshippingratecountry']['country_id'] ];?></td>
							<td><?php echo $fixedshippingratecountry['Fixedshippingratecountry']['rate'];?></td>
						
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $fixedshippingratecountry['Fixedshippingratecountry']['id'])); ?>
								<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $fixedshippingratecountry['Fixedshippingratecountry']['id']), null, __('Are you sure you want to delete # %s?', $fixedshippingratecountry['Fixedshippingratecountry']['id'])); ?>
							</td>
						</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<!-- table wrapper -->
</div>
</div>
