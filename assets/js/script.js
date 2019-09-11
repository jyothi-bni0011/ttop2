$(document).ready(function(){
	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
	$(function () {

	    $('#user_info').popover({
	    	html: true,
	    	//trigger: 'hover',
	        title: 'User Information',
	        //content: $('#popoverEditPerson').html(),
	        placement: 'right'
	    })
	});

	
	$('#tableExport1').DataTable( {
        dom: 'Bfrtip',
        "ordering": false,
        "oLanguage": {
	        "sEmptyTable": "Timesheet is not avaliable for this week."
	    },
        buttons: [
            
           {
               extend: 'pdfHtml5',
               
               /*exportOptions: {
                    columns: "thead th:not(.noExport)"
                },*/
                orientation: 'landscape',
                pageSize: 'LEGAL',
           },
           {
               extend: 'csv',
               // exportOptions: {
               //      columns: "thead th:not(.noExport)"
               //  }
           },
           {
               extend: 'excel',
               // exportOptions: {
               //      columns: "thead th:not(.noExport)"
               //  }
           },
           {
               extend: 'copy',
               // exportOptions: {
               //      columns: "thead th:not(.noExport)"
               //  }
           },
        ] 
    } );


    var start=end='';

    $('#start_date').change(function(){
		$('.form_date_end').datetimepicker('remove');
		$('.form_date_end').datetimepicker({
		    weekStart: 1,
		    todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0,
			startDate : new Date( $(this).val() ),
			endDate : end
		});
	});

	$('#end_date').change(function(){
		$('.form_date_start').datetimepicker('remove');
		$('.form_date_start').datetimepicker({
		    weekStart: 1,
		    todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0,
			startDate : start,
			endDate : new Date( $(this).val() )
		});
	});

});