<?php 

		$options = array();
		$options['url'] = array();
		$options['url']['controller'] = "Uploads";
		$options['url']['action'] = "product_dimensions";
		$options['enctype'] = "multipart/form-data";

		echo $this->Form->create('Productdimension',$options);
		echo $this->Form->file('excel_file');

		echo "<hr/>";
		echo $this->Form->end('Excel Upload');

?>