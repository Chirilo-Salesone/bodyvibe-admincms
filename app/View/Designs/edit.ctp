<div class="row">
	<div class="col-md-12">
	<?php echo $this->Form->create('Design',array('class'=>'admin-forms')); ?>

		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('name');
			echo $this->Form->input('description');
			echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'Inactive')));
		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>

</div>


<div class="row">
		<div class="col-md-12">
			<h1 class="page-header"> Products </h1>
			
				<?php 
					$productsArr = array();
				    foreach($products as  $prod_id => $number) {
				    	$productsArr[] = $this->Html->link($number,'/products/edit/'.$prod_id); 
				    }	

				    echo implode(", ",$productsArr);
				?>			

		</div>

</div>