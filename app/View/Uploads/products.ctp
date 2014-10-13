<?php 

		$options = array();
		$options['url'] = array();
		$options['url']['controller'] = "uploads";
		$options['url']['action'] = "products";
		$options['enctype'] = "multipart/form-data";

		echo $this->Form->create('Product',$options);
		echo $this->Form->file('excel_file');

		echo "<hr/>";
		echo $this->Form->end('Excel Upload File');

?>