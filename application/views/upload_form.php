<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('ct_upload/do_upload');?>


<input type="file" name="userfile" onchange="submit();">
<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>