<div class="row">
	<div class="col-md-12">

	<?php 

		$options = array();
		for($loop=1;$loop<=$list_options;$loop++){

			$lowerIndex = ($loop-1) * $item_per_file;
			$upperIndex = $item_per_file * $loop;

			$options[] = "Product List {$lowerIndex}	-	{$upperIndex}";
		}


		echo $this->Form->create($this->name,array('class'=>'admin-forms'));
		echo $this->Form->input('list',array('label'=>'List Options','style'=>'width: 300px','options'=>$options));

	 	echo $this->Form->end('Export Product List'); 

	?>

	</div>


</div>

