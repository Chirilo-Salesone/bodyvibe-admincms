<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />
	<?php 



		$formOptions = array(
						'class'=>'admin-forms',
						'action'=>"/".$this->request->params['action']
					   );


		echo $this->Form->create('Product',$formOptions);?>

		<?php

			$optionArr = array('active'=>'Active','inactive'=>'Inactive');

			    echo $this->Form->input('id',array('type'=>'hidden'));
				echo $this->Form->input('image_name');
				echo $this->Form->input('brand_id');
				echo $this->Form->input('description');
				echo $this->Form->input('number');
				echo $this->Form->input('emailerlink');
				echo $this->Form->input('price');
				echo $this->Form->input('promocode');
				echo $this->Form->input('discount_value');
				echo $this->Form->input('discount_chart',array('options'=>$optionArr));
				echo $this->Form->input('package_deal',array('options'=>$optionArr));
				echo $this->Form->input('view_piece');
				echo $this->Form->input('view_pack');
				echo $this->Form->input('rank');
				echo $this->Form->input('db_name');
				echo $this->Form->input('new_styles',array('options'=>$optionArr));
				echo $this->Form->input('generate_email',array('options'=>$optionArr));
				echo $this->Form->input('avail_qty');
				echo $this->Form->input('packaging');
				echo $this->Form->input('status',array('options'=>$optionArr));

		?>
	<?php echo $this->Form->end('Submit'); ?>

	</div>

</div>


<br/>


<div class="row">
		<div class="col-md-12">
			<h1 class="page-header"> Categories </h1>
			
				<?php 
					$categoriesArr = array();
				    foreach($categories as  $index => $val) {
				    	$categoriesArr[] = $this->Html->link($val,'/categories/edit/'.$index); 
				    }	

				    echo implode(", ",$categoriesArr);
				?>
			

		</div>

</div>

<div class="clearfix"><br/><br/></div>


<div class="clearfix"><br/><br/></div>


<div class="row">
		<div class="col-md-12">
			<h1 class="page-header"> Materials </h1>
			
				<?php 
					$materialsArr = array();
				    foreach($materials as  $index => $val) {
				    	$materialsArr[] = $this->Html->link($val,'/materials/edit/'.$index); 
				    }	

				    echo implode(", ",$materialsArr);
				?>			

		</div>

</div>

