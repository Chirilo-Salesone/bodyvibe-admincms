<div class="row">
<div class="col-md-12">


	<!-- pagination -->
		<div class="paging">
			<?php
				$pagination = $this->Paginator->numbers();

				if($pagination!=""){

					echo $this->Paginator->prev("< prev ",array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ' | '));
					echo $this->Paginator->next(" next >", array(), null, array('class' => 'next disabled'));
				}

			?>
		</div>
	<!-- pagination -->
	<br/>

	<!-- table wrapper -->
	<div class="table-responsive">

		<table class="table table-hover table-bordered table-condensed custom-admin-listing">
		
			<thead class="active">
				<th> Customer </th>
				<th> Date Added </th>
				<th> Coupon </th>
				<th> Company </th>
				<th> Phone </th>
				<th> Total Amount </th>
				<th class="row-option">Options</th>
			</thead>	

			<tbody>
			<?php foreach($carts as $cart){ ?>
				<tr style="cursor: pointer;" id="<?php echo $cart['Cart']['id'];?>" data-url="<?php echo EDIT_CART.$cart['Cart']['id']?>">
					<td> 
					    <?php echo $cart['Customer']['ship_fname']; ?>
					    <?php echo $cart['Customer']['ship_lname']; ?>
						( <?php echo $cart['Customer']['email']?> )
					</td>
					<td><?php echo date('F d, Y H:i:s a',strtotime($cart['Cart']['added']));?></td>
					<td><?php echo (empty($cart['Coupon']['id'])) ? "no" : "yes";?></td>
					<td><?php echo $cart['Customer']['ship_company']?></td>
					<td><?php echo $cart['Customer']['ship_phone']?></td>
					<td><?php echo '$'.$cart['Cart']['shoptotal']?></td>
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




</div>
</div>
<script type="text/javascript">

	(function($){
		$('table tr').on('click', function(){
			window.location.href = $(this).data('url');
		});
	}(jQuery));

</script>
