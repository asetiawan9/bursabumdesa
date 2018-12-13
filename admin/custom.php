<script type="text/javascript">
function prjt_img1() {
	var prjtId11 = document.getElementById('dynamicid1').value;
	var prjtId12 = document.getElementById('dynamicid2').value;
	var prjtId13 = document.getElementById('dynamicid3').value;
	var prjtId14 = document.getElementById('dynamicid4').value;
	var vdofile = document.getElementById('dynamicid5').value;
	var prjtId1 = prjtId11;
	if(prjtId1 == 'none') prjtId1 = prjtId12;
	if(prjtId1 == 'none') prjtId1 = prjtId13;
	if(prjtId1 == 'none') prjtId1 = prjtId14;
	if(prjtId1 == 'none') prjtId1 = vdofile;
	if(prjtId1 == 'none') prjtId1 = 'none';
	var formData = new FormData();
	formData.append('img1', $('input[name=img1]')[0].files[0]);
	$("#showimg1").html("<img src='<?=dirname($baseUrl);?>/images/load.gif' height='100px;' width='100px;' alt='loading' />");
	
	$.ajax({
		url: '<?=$baseUrl;?>/project_img_ajax.php?prjt_id1='+prjtId1,
		data: formData,
		type: 'POST',
		contentType: false,
		processData: false, 
		success: function (response) {
		if(response == 'Missmatch Image format') {
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg1' ).html(response);
			return false;		   
		}
		else if(response=='Image missing')	{
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg1' ).html(response);
			return false;	
		}
		else {
			$('#imgId1').removeClass('hidden');
			$( '#showimg1' ).html(response);
			return true;	
		}
	  }
	});
}

function prjt_img2() {
	var prjtId11 = document.getElementById('dynamicid1').value;
	var prjtId12 = document.getElementById('dynamicid2').value;
	var prjtId13 = document.getElementById('dynamicid3').value;
	var prjtId14 = document.getElementById('dynamicid4').value;
	var vdofile = document.getElementById('dynamicid5').value;
	var prjtId2 = prjtId11;
	if(prjtId2 == 'none') prjtId2 = prjtId12;
	if(prjtId2 == 'none') prjtId2 = prjtId13;
	if(prjtId2 == 'none') prjtId2 = prjtId14;
	if(prjtId2 == 'none') prjtId2 = vdofile;
	if(prjtId2 == 'none') prjtId2 = 'none';
	var formData = new FormData();
	formData.append('img2', $('input[name=img2]')[0].files[0]);
	$("#showimg2").html("<img src='<?=dirname($baseUrl);?>/images/load.gif' height='100px;' width='100px;' alt='loading' />");
	
	$.ajax({
		url: '<?=$baseUrl;?>/project_img_ajax.php?prjt_id2='+prjtId2,
		data: formData,
		type: 'POST',
		contentType: false,
		processData: false, 
		success: function (response) {
		if(response == 'Missmatch Image format') {
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg2' ).html(response);
			return false;		   
		}
		else if(response=='Image missing')	{
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg2' ).html(response);
			return false;	
		}
		else {
			$('#imgId2').removeClass('hidden');
			$( '#showimg2' ).html(response);
			return true;	
		}
	  }
	});
}

function prjt_img3() {
	var prjtId11 = document.getElementById('dynamicid1').value;
	var prjtId12 = document.getElementById('dynamicid2').value;
	var prjtId13 = document.getElementById('dynamicid3').value;
	var prjtId14 = document.getElementById('dynamicid4').value;
	var vdofile = document.getElementById('dynamicid5').value;
	var prjtId3 = prjtId11;
	if(prjtId3 == 'none') prjtId3 = prjtId12;
	if(prjtId3 == 'none') prjtId3 = prjtId13;
	if(prjtId3 == 'none') prjtId3 = prjtId14;
	if(prjtId3 == 'none') prjtId3 = vdofile;
	if(prjtId3 == 'none') prjtId3 = 'none';
	var formData = new FormData();
	formData.append('img3', $('input[name=img3]')[0].files[0]);
	$("#showimg3").html("<img src='<?=dirname($baseUrl);?>/images/load.gif' height='100px;' width='100px;' alt='loading' />");
	
	$.ajax({
		url: '<?=$baseUrl;?>/project_img_ajax.php?prjt_id3='+prjtId3,
		data: formData,
		type: 'POST',
		contentType: false,
		processData: false, 
		success: function (response) {
		if(response == 'Missmatch Image format') {
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg3' ).html(response);
			return false;		   
		}
		else if(response=='Image missing')	{
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg3' ).html(response);
			return false;	
		}
		else {
			$('#imgId3').removeClass('hidden');
			$( '#showimg3' ).html(response);
			return true;	
		}
	  }
	});
}

function prjt_img4() {
	var prjtId11 = document.getElementById('dynamicid1').value;
	var prjtId12 = document.getElementById('dynamicid2').value;
	var prjtId13 = document.getElementById('dynamicid3').value;
	var prjtId14 = document.getElementById('dynamicid4').value;
	var vdofile = document.getElementById('dynamicid5').value;
	var prjtId4 = prjtId11;
	if(prjtId4 == 'none') prjtId4 = prjtId12;
	if(prjtId4 == 'none') prjtId4 = prjtId13;
	if(prjtId4 == 'none') prjtId4 = prjtId14;
	if(prjtId4 == 'none') prjtId4 = vdofile;
	if(prjtId4 == 'none') prjtId4 = 'none';
	var formData = new FormData();
	formData.append('img4', $('input[name=img4]')[0].files[0]);
	$("#showimg4").html("<img src='<?=dirname($baseUrl);?>/images/load.gif' height='100px;' width='100px;' alt='loading' />");
	
	$.ajax({
		url: '<?=$baseUrl;?>/project_img_ajax.php?prjt_id4='+prjtId4,
		data: formData,
		type: 'POST',
		contentType: false,
		processData: false, 
		success: function (response) {
		if(response == 'Missmatch Image format') {
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg4' ).html(response);
			return false;		   
		}
		else if(response=='Image missing')	{
			response='<p style="color:red;">'+response+'</p>';
			$( '#showimg4' ).html(response);
			return false;	
		}
		else {
			$('#imgId4').removeClass('hidden');
			$( '#showimg4' ).html(response);
			return true;	
		}
	  }
	});
}

function video_upload() {
	var prjtId11 = document.getElementById('dynamicid1').value;
	var prjtId12 = document.getElementById('dynamicid2').value;
	var prjtId13 = document.getElementById('dynamicid3').value;
	var prjtId14 = document.getElementById('dynamicid4').value;
	var vdofile = document.getElementById('dynamicid5').value;
	var vdoId = prjtId11;
	if(vdoId == 'none') vdoId = prjtId12;
	if(vdoId == 'none') vdoId = prjtId13;
	if(vdoId == 'none') vdoId = prjtId14;
	if(vdoId == 'none') vdoId = vdofile;
	if(vdoId == 'none') vdoId = 'none';
	var formData = new FormData();
	formData.append('video', $('input[name=video]')[0].files[0]);
	$("#showvdo").html("<img src='<?=dirname($baseUrl);?>/images/load.gif' height='100px;' width='100px;' alt='loading' />");
	
	$.ajax({
		url: '<?=$baseUrl;?>/project_img_ajax.php?vdo_file='+vdoId,
		data: formData,
		type: 'POST',
		contentType: false,
		processData: false, 
		success: function (response) {
		if(response == 'Missmatch Video format') {
			response='<p style="color:red;">'+response+'</p>';
			$( '#showvdo' ).html(response);
			return false;		   
		}
		else if(response=='Video file missing')	{
			response='<p style="color:red;">'+response+'</p>';
			$( '#showvdo' ).html(response);
			return false;	
		}
		else {
			$('#vdoId').removeClass('hidden');
			$( '#showvdo' ).html(response);
			return true;	
		}
	  }
	});
}
</script>