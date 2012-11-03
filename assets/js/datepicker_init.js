$(document).ready(function(){
	//configure the date format to match mysql date
	$('#date, #date_created, #date_completed, #first_semester_start,#first_semester_end,#second_semester_start,#second_semester_end,').datepick({dateFormat: 'yy-mm-dd'});
});