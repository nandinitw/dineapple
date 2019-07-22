<div id="main-container">
    <div class="row">
		<div class="col-md-12">
		  <h1><?php echo $title; ?></h1>
		</div>

		<?php if( !empty($this->session->flashdata('message')) ):?>
		<div class="col-md-12 alert alert-info">
			<?php echo $this->session->flashdata('message'); ?>
		</div>
		<?php endif; ?>

	   	<?php $attributes = array('class' => 'userAccessform', 'id' => 'userAccessform', 'method'=>'POST'  ); ?>

				


    </div>
</div>
<script>
	function fetchModules(item, url){
		var user = item.value;
		 if( url && user){
			var redirect = url+'?q='+user;
		 }else{
			var redirect = url
		 }
		 window.location.replace(redirect);
	}
</script>
