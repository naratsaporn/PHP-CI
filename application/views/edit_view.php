<!DOCTYPE html>
<html>
<head>
	<title>edit_view</title>
</head>
<body>
	<?php 
	$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$data = parse_url($url);
	$member_id = basename($data['path'], '.html');
	echo "<input id='member_id' type='hidden' value='".$member_id."'' > ";
	?>

		

		username <input type="text" id="username" name="username" > <br>
		password <input type="text" id="password" name="password"> <br>
			     <input type="hidden" id="img_name" name="img_name"> <br>
				 <input id="edit_member" type="button" name="" value="แก้ไข">
</body>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script>

	$(document).ready(function(){



		var member_id =  $("#member_id").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('ct_member/edit'); ?>",
			data: {
				member_id : member_id			
			},
			dataType: "text",
			cache: false,
		}).done(function (data) {
			var json_obj = JSON.parse(data);
			console.log(json_obj);

			$.each(json_obj, function (key, detail) {
				$("#username").val(detail.username);
				$("#password").val(detail.password);
				var u_score = detail.img_name;
				if(u_score==0){
        			alert("You pass");
    			 }else{
 			        alert("You fail");  
     			 }
				
					
			});

		});




		$('body').on('click', "#edit_member", function (event) {

			var username =  $("#username").val();
			var password =  $("#password").val();
			

			$.ajax({
				type: "POST",
				url: "<?php echo base_url('ct_member/edit_member_data'); ?>",
				data: {
					member_id : member_id,
					username : username	,	
					password : password	
				},
				dataType: "text",
				cache: false,

			}).done(function (data) {

			console.log(data);
			
				

			});

		});


		



	});




</script>
</html>