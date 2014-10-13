<div class="row">
<div class="col-md-12">

		<!-- <a href="<?php //echo Router::url('/',true).$this->request->params['controller']."/add"; ?>" class="btn btn-success btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-plus"></span> Add Category
		</a>
		<br />
		<br /> -->

		<?php
			/*pr( count($orders) );*/
			/*pr( count($orders) );*/
			/*pr( $orders );*/
		?>

		<?php /*pagination*/ ?>
			<div class="paging">
				<?php

					echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ' | '));
					echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));

				?>
			</div>
		<?php /*pagination*/ ?>
		<br/>

			<?php /*table wrapper*/ ?>
			<div class="table-responsive">

				<table class="table table-hover table-bordered table-condensed custom-admin-listing">
				
					<thead class="active">
						<th>ID</th>
						<th>Customer</th>
						<th>Order Date</th>
						<th>Company Name</th>
						<th>Order Amount</th>
						<th>Order Mode</th>
						<th>Status </th>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($orders as $order){ ?>
						<tr style="cursor: pointer;" id="<?php echo $order['Order']['id']; ?>" data-url="<?php echo EDIT_ORDER.$order['Order']['id']?>">
							<td><?php echo $order['Order']['id']; ?></td>
							<td><?php echo ucfirst($order['OrderCustomer']['ship_fname']). ' ' .ucfirst($order['OrderCustomer']['ship_lname']); ?></td>
							<td><?php echo date('F d, Y H:i:s a',strtotime($order['Order']['added'])); ?></td>
							<td><?php echo $order['OrderCustomer']['ship_company']; ?></td>
							<td>$<?php echo $order['Payment']['charge']; ?></td>
							<td><?php echo $order['Order']['mode']; ?></td>
							<td><?php echo $order['Order']['status']; ?></td>				
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $order['Order']['id'])); ?>
								<?php 

									if($order['Order']['status']=="active"){
										echo $this->Form->postLink('Deactivate', array('action' => 'deactivate', $order['Order']['id']), null, __('Are you sure you want to Deactivate # %s?', $order['Order']['id'])); 
									}
									else{
										
										echo $this->Form->postLink('Activate', array('action' => 'activate', $order['Order']['id']), null, __('Are you sure you want to Activate # %s?', $order['Order']['id'])); 

									}
								?>
							</td>
						</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
			<?php /*table wrapper*/ ?>

			<?php /*pagination*/ ?>
				<div class="paging">
					
				</div>
			<?php /*pagination*/ ?>

</div>
</div>

<script type="text/javascript">

	(function($){
		$('table tr').on('click', function(){
			window.location.href = $(this).data('url');
		});
	}(jQuery));

</script>
