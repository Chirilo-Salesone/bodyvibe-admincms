<?php 

		$options = array();
		$options['url'] = array();
		$options['url']['controller'] = "Uploads";
		$options['url']['action'] = "product_quantities";
		$options['enctype'] = "multipart/form-data";

		echo $this->Form->create('Products_quantity',$options);
		echo $this->Form->file('excel_file');

		echo "<hr/>";
		echo $this->Form->end('Excel Upload');

?>