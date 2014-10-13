<div class="row">
<div class="col-md-12">


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
						
						<th>Product Number</th>
						<th>Identification</th>
						<th>Color</th>
						<th>GaugeInch</th>
						<th>LengthInch</th>
						<th>WidthInch</th>
						<th>GaugeMM</th>
						<th>LengthMM</th>
						<th>WidthMM</th>
						<th>Ball/Gem Size</th>
						<th>Length</th>
						<th>Width</th>
						<th>Height</th>
						<?php /*<th>Weight </th>*/ ?>
						<th class="row-option">Options</th>
					</thead>	

					<tbody>
					<?php foreach($productdimensions as $productdimension){ ?>
						<tr>
							
							<td><?php echo $productdimension['Product']['number']; ?></td>
 							<td><?php echo $productdimension['Product']['identification']; ?></td>
							<td><?php echo $productdimension['Color']['name']; ?></td>
							<td><?php echo $productdimension['Productdimension']['gaugeinch']; ?></td>
							<td><?php echo $productdimension['Productdimension']['lengthinch']; ?></td>
							<td><?php echo $productdimension['Productdimension']['widthinch']; ?></td>
							<td><?php echo $productdimension['Productdimension']['gaugemm']; ?></td>
							<td><?php echo $productdimension['Productdimension']['lengthmm']; ?></td>
							<td><?php echo $productdimension['Productdimension']['widthmm']; ?></td>
							<td><?php echo $productdimension['Productdimension']['ball_gem_size']; ?></td>
							<td><?php echo $productdimension['Productdimension']['length']; ?></td>
							<td><?php echo $productdimension['Productdimension']['width']; ?></td>
							<td><?php echo $productdimension['Productdimension']['height']; ?></td>
							
							<td class="actions">
								<?php echo $this->Html->link('Edit', array('action' => 'edit', $productdimension['Productdimension']['id'])); ?>
							</td>
							
						</tr>

						<?php } ?>
					</tbody>

				</table>



			</div>
		


</div>
</div>
