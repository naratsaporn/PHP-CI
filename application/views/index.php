<!DOCTYPE html>
<html>
<head>
	<title>index</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style type="text/css">
		.div1 {
				
				margin: 20px;
			
				float: left;
				
				
			  }
		.div2 {
				
				margin: 10px;
				float: left;
			  }
	</style>
</head>
<body>

	<h1>This is a Heading</h1>
	<p>This is a paragraph.</p>
	<table border="1" id="add">
		<tr>
			<th>#</th>
			<th>username</th> 
			<th>password</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		<?php 
		$number = 1;
		foreach ($member_list as $member ) {
			?>
			<tr class="for_count" id="row<?=$member->member_id?>">
				<td><?=$number?></td>
				<td id="member_username<?=$member->member_id?>"><?=$member->username?></td>
				<td id="member_password<?=$member->member_id?>"><?=$member->password?></td>
				<td>
					<input type="button" value="แก้ไข" m_id="<?=$member->member_id?>"  data-toggle="modal" data-target="#myModal<?=$member->member_id?>">
				</td>
				<td><input type="button" name="delete_member" value="ลบ" m_id="<?=$member->member_id?>"></td>
			</tr>


			<!-- Modal -->
			<div class="modal fade" id="myModal<?=$member->member_id?>" role="dialog">
				<div class="modal-dialog">
					
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modal Header</h4>
						</div>
						<div class="modal-body">
							<?php
							if ($member->img_name == NULL) {
								
								$txt = 'อัพโหลดรูปภาพ : ';
								?>


								<?php	}else{ 
									$txt = 'อัพเดทรูปภาพ : ';
									?>

									<img src="<?php echo base_url("assets/upload/".$member->img_name."");?>" width="70"><br>


									<?php  }
									echo $txt;

									echo form_open_multipart('ct_upload/do_upload'); ?>

									<input type="hidden" name="member_id" value="<?=$member->member_id?>">
									<input type="file" name="userfile" onchange="submit();">
									<br /><br />

									
									<br>
								</form>
								
								
								username <input type="text" id="username_edit" name="username" value="<?=$member->username?>"> <br>
								password <input type="text" id="password_edit" name="password" value="<?=$member->password?>"> <br>
							</div>
							<div class="modal-footer">
								<input  type="button" name="edit_member" value="แก้ไข" m_id="<?=$member->member_id?>" data-dismiss="modal"><br>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
						
					</div>
				</div>


				<?php  
				$number++;}
				?>
			</table>
			<br>

			<table >
				username<input type="text" id="username_add" name="username"> <BR>
				password<input type="text" id="password_add" name="password"> <BR>
				<input type="button" id="add_member" name="add" value="เพิ่ม">


			</table>


		</body>
		<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
		<script>

			$(document).ready(function(){

				// $('body').on('click', "[name='edit_member']", function (event) {
				// 		//$(this).attr("test","99");
				// 		var member_id =  $(this).attr("m_id");
				// 		var username =  $("#username"+member_id+"").val();
				// 		var password =  $("#password"+member_id+"").val();
				// 		// $(this).val("OK");
				// 		//console.log(username);
				// 	$.ajax({
				// 		type: "POST",
				// 		url: "<?php echo base_url('ct_member/edit_member'); ?>",
				// 		data: {
				// 			member_id : member_id,
				// 			username : username,
				// 			password : password
				// 		},
				// 		dataType: "text",
				// 		cache: false,
				// 	}).done(function (data) {
				// 		console.log(data);
				// 	});

				// });

				$('body').on('click', "[name='edit_member']", function (event) {

					var username =  $("#username_edit").val();
					var password =  $("#password_edit").val();

					var member_id =  $(this).attr("m_id");	

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

						$("#member_username"+member_id+"").html(username);
						$("#member_password"+member_id+"").html(password);	

					});

				});



				$('body').on('click', "#add_member", function (event) {
					var username =  $("#username_add").val();
					var password =  $("#password_add").val();			
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('ct_member/insert_member_data'); ?>",
						data: {
							
							username : username,
							password : password
						},
						dataType: "text",
						cache: false,


					}).done(function (data) {
						//console.log(data);
						var number = $("tr.for_count").length+1;
						
						// $("table > tr").each(function(){

						// 	//number = 0;
						// });

						// append ต่อข้างล่า
						// prepend ต่อข้างบน
						var url = "http://localhost/project/ct_member/edit_member/"+data+"";
						$("#add").append('\n\
							<tr class="for_count" id="row'+data+'" > \n\
								<td>'+number+'</td>\n\
								<td><input type="text" id="username'+data+'" name="username" value="'+username+'" ></td>\n\
								<td><input type="text" id="password'+data+'" name="password" value="'+password+'"></td>\n\
								<td>\n\
								<input type="button" value="แก้ไข" m_id="'+data+'"  data-toggle="modal" data-target=#myModal'+data+'\n\
								</td>\n\
								<td><input type="button" name="delete_member" name="" value="ลบ" m_id="'+data+'"></td>\n\
								\n\ </tr>\n\
								');
					});
				});





				$('body').on('click', "[name='delete_member']", function (event) {
					
					var member_id =  $(this).attr("m_id");	

					$.ajax({
						type: "POST",
						url: "<?php echo base_url('ct_member/delete_member'); ?>",
						data: {
							member_id : member_id
						},
						dataType: "text",
						cache: false,


					}).done(function (data) {
						//console.log(data);
						$("#row"+member_id+"").fadeOut(1000);
					});
				});
















			});

		</script>
		</html>