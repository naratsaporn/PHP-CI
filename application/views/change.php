<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/costom.css'); ?>">
	<style type="text/css">
		.ff{
			color:red;

		}
	</style>
</head>

<body>

	<select name="coacar" id="coacar">
		<option value="1"> car</option>
		<option value="2"> car2</option>
		<option value="3"> car3</option>
	</select>
	<br>
	<h1 id="h_one" class="ff">asdasdas kajsdkasjdkasd asd asdadsa</h1>
	<button id="submit_1">กด</button>

</body>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script>
	$(document).ready(function(){
		$("#coacar").change(function(){
			var val_car = $("#coacar").val();
		});

		$('body').on('click', "#submit_1", function (event) {
			$("#h_one").css("font-size","40px");
			// $("#h_one").removeClass("ff");
			// $("#h_one").addClass("red");
		});
	});
</script>

</html>