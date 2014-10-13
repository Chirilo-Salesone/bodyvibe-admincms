<div class="row">
	<div class="col-md-12">

		<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
				<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
		</a>
		<br />
		<br />


		<?php echo $this->Form->create('Productdimension',array('class'=>'admin-forms')); ?>

		<?php

			echo $this->Form->input('id', array('type'=>'hidden'));
			echo $this->Form->input('product_id', array('type'=>'hidden'));
			echo $this->Form->input('identification',
					array(
						'options' => $identifications,
						'value'=>$this->request->data['Product']['identification']
					)
				);

			echo $this->Form->input('color',
					array(
							'options'=>$colors,
							'value'=>$this->request->data['Color']['id']
						)
				);

			echo $this->Form->input('gaugeinch');
			echo $this->Form->input('lengthinch');
			echo $this->Form->input('widthinch');
			echo $this->Form->input('gaugemm');
			echo $this->Form->input('lengthmm');
			echo $this->Form->input('widthmm');
			echo $this->Form->input('ball_gem_size');
			echo $this->Form->input('length');
			echo $this->Form->input('width');
			echo $this->Form->input('height');

		?>
	    
	    <?php echo $this->Form->end('Submit'); ?>

	</div>

</div>