<div class="row">
	<div class="col-md-12">

	<a href="<?php echo Router::url('/',true).$this->request->params['controller']; ?>" class="btn btn-default btn-md pull" role="button">
			<span class="glyphicon glyphicon glyphicon-chevron-left"></span> &nbsp; Back
	</a>			

	<hr/>

	<?php 
		echo $this->Form->create($this->name,array('class'=>'admin-forms'));
		echo $this->Form->input('title');
		echo $this->Form->input('content');
			
	 	echo $this->Form->end('Submit'); 

	?>

	</div>

</div>


<script type="text/javascript" src="<?php echo Router::url('/',true);?>js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
	tinymce.init({
	    selector: "textarea",
	    plugins: [
	        "autolink lists link image charmap preview anchor",
	        "searchreplace visualblocks code",
	        "media  paste"
	    ],
	    toolbar: ""
	});

</script>

