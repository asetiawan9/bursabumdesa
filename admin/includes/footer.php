  <footer class="footer footer-static footer-light navbar-border">
		<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
			<span class="float-md-left d-xs-block d-md-inline-block"><?php echo $site_title." &copy; ".date("Y"); ?>.</span> 
		</p>
    </footer>
	
    <script src="<?php echo $baseUrl; ?>assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/core/app.js" type="text/javascript"></script>
    <script src="<?php echo $baseUrl; ?>assets/plugins/datatable/datatables.min.js" type="text/javascript"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.6/tinymce.min.js" type="text/javascript"></script>
	<script>tinymce.init({ selector:'.tinymce' });</script>
	<script type="text/javascript">
	$(function() {
		//$.validate({modules : 'security'});
		$('#datatable').DataTable();
	});
	</script>
<!--datepicker-->
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {  
	$( "#start_dt" ).datepicker({
		defaultDate: "+1w",  
		changeMonth: true,   
		numberOfMonths: 1,
		dateFormat: 'dd/mm/yy',	
		minDate: 0,
		onClose: function( selectedDate ) 
		{  
		$( "#end_dt" ).datepicker( "option", "minDate", selectedDate );  
		}  
	});  
	$( "#end_dt" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd/mm/yy',
		minDate: 0,
		onClose: function( selectedDate ) {
		$( "#start_dt" ).datepicker( "option", "maxDate", selectedDate );
		}
	});  
});
</script>
<!-- validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="<?=dirname($baseUrl); ?>/assets/js/custom-validation.js"></script>
<!-- validation end -->
  </body>
</html>