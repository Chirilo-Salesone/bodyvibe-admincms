<div class="row">
<div class="col-md-12">


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
				<th> Customer </th>
				<th> Email </th>
				<th> Company </th>
				<th> Phone </th>
				<th> Total Amount </th>
				<th>Added</th>
				<th class="row-option">Options</th>
			</thead>	

			<tbody>
			<?php foreach($carts as $cart){ ?>
				<tr>
					<td> 
					    <?php echo $cart['Customer']['ship_fname']; ?>
					    <?php echo $cart['Customer']['ship_lname']; ?>
					</td>
					<td><?php echo $cart['Customer']['email']?></td>
					<td><?php echo $cart['Customer']['ship_company']?></td>
					<td><?php echo $cart['Customer']['ship_phone']?></td>
					<td><?php echo '$'.$cart['Cart_summary']['cart_total']?></td>
					<td><?php echo $cart['Cart']['added']?></td>
					<td class="actions">
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $cart['Cart']['id'])); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $cart['Cart']['id']), null, __('Are you sure you want to delete # %s?', $cart['Cart']['id'])); ?>
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
	<br/>	


</div>
</div>
