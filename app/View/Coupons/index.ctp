<div class="row">
<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Coupon
		</a>
		<br />
		<br />

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
							<!-- <th><?php /*echo $this->Paginator->sort('id');*/ ?></th> -->
							<th> Name <?php /*echo $this->Paginator->sort('name');*/ ?></th>
							<th> PromoCode <?php /*echo $this->Paginator->sort('promocode');*/ ?></th>
							<th> Date Start <?php /*echo $this->Paginator->sort('datestart');*/ ?></th>
							<th> Date End <?php /*echo $this->Paginator->sort('dateend');*/ ?></th>
							<th> Discount Rate <?php /*echo $this->Paginator->sort('discountrate');*/ ?></th>
							<th> Type <?php /*echo $this->Paginator->sort('type'); */?></th>
							<th> Minimum Amount <?php /*echo $this->Paginator->sort('minimumamount');*/ ?></th>
							<th> Available <?php /*echo $this->Paginator->sort('available');*/ ?></th>
							<th> Remaining <?php /*echo $this->Paginator->sort('remaining');*/ ?></th>
							<th> Details <?php /*echo $this->Paginator->sort('details');*/ ?></th>
							<th> Status <?php /*echo $this->Paginator->sort('status');*/ ?></th>
							<!-- <th><?php /*echo $this->Paginator->sort('dateadded');*/ ?></th> -->
							<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($coupons as $Coupon){ ?>
						<tr>
	
							<!-- <td><?php /*echo $Coupon['Coupon']['id'];*/ ?>&nbsp;</td> -->
							<td><?php echo $this->Form->postLink($Coupon['Coupon']['name'], array('action' => 'view', $Coupon['Coupon']['id'])); ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['promocode']; ?>&nbsp;</td>
							<td><?php echo date('F n, Y', strtotime( $Coupon['Coupon']['datestart']) ); ?>&nbsp;</td>
							<td><?php echo date('F n, Y', strtotime( $Coupon['Coupon']['dateend']) ); ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['discountrate']; ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['type']; ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['minimumamount']; ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['available']; ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['remaining']; ?>&nbsp;</td>
							<td><?php echo $Coupon['Coupon']['details']; ?>&nbsp;</td>
							<td>
								<?php 

									if( $Coupon['Coupon']['status'] == 0 ){
										$Coupon['Coupon']['status'] = 'inactive';
									}
									elseif( $Coupon['Coupon']['status'] == 1 ){
										$Coupon['Coupon']['status'] = 'active';
									}
									echo $Coupon['Coupon']['status']; 
								?>

								&nbsp;
							</td>
							<!-- <td><?php /*echo $Coupon['Coupon']['dateadded'];*/ ?>&nbsp;</td> -->
							<td class="actions">
								<?php /*echo $this->Html->link(__('View'), array('action' => 'view', $Coupon['Coupon']['id']));*/ ?>
								<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $Coupon['Coupon']['id'])); ?>

								<?php 

									if($Coupon['Coupon']['status']=="active"){
										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $Coupon['Coupon']['id']), null, __('Are you sure you want to Deactivate # %s?', $Coupon['Coupon']['name'])); 
									}
									else{
										
										echo $this->Form->postLink('Activate', array('action' => 'activate', $Coupon['Coupon']['id']), null, __('Are you sure you want to Activate # %s?', $Coupon['Coupon']['name'])); 

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
