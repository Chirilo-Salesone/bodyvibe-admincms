<div class="row">
	<div class="col-md-12">

	<?php 

		$current_date = date("Y-m-d",strtotime('now'));

		echo $this->Form->create($this->name,array('class'=>'admin-forms'));
		echo $this->Form->input('start_date',array('label'=>'Start Date','style'=>'width: 200px','value'=>$current_date));
		echo $this->Form->input('end_date',array('label'=>'End Date','style'=>'width: 200px','value'=>$current_date));

	 	echo $this->Form->end('Export List'); 

	?>

	</div>

	<script type="text/javascript">

		$(function(){

			$("input[name*=date]").datepicker( {dateFormat:"yy-mm-dd"} );
		});

	</script>

</div>

