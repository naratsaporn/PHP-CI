<!DOCTYPE html>
<html>
<head>
	<title>data_table</title>
</head>
<link href="<?php echo base_url('assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />

<body>
	<table id="member_list_table" >
		<thead>
			<tr class="t-head">
				<th style="width:1%"><center>#</center></th>
				<th> username </th>
				<th> password </th>
				<th><center>แก้ไข</center></th>
				<th><center>ลบ</center></th>
			</tr>
		</thead>
		<tbody id="tbody_id">

		</tbody>
	</table>

</body>


<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/global/scripts/datatable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/table-datatables-rowreorder.min.js'); ?>" type="text/javascript"></script>
<!--<script src="<?php //echo base_url('assets/alert/sweetalert/dist/sweetalert.min.js');         ?>"></script>-->



<script type="text/javascript">

	$(document).ready(function(){

		var table = $('#member_list_table');

        var oTable = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },
            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            "sAjaxSource": "<?php echo site_url('ct_member/data_table'); ?>",
            "bServerSide": true,
            "sServerMethod": "POST",
            "bSort": false,
            "ordering": false,
            'fnServerData': function (sSource, aoData, fnCallback) {

                $.ajax({
                    url: sSource,
                    type: 'POST',
                    cache: false,
                    data: aoData,
                    dataType: 'jsonp',
                    jsonp: 'jsoncallback',
                    success: fnCallback
                });
            },
            'fnDrawCallback': function (oSettings) {
                // $("input[name='my-checkbox']").bootstrapSwitch();
            },
            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [
                {extend: 'print', className: 'btn dark btn-outline'},
                {extend: 'pdf', className: 'btn green btn-outline'},
                {extend: 'csv', className: 'btn purple btn-outline '}
            ],
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });


	});



</script>
</html>