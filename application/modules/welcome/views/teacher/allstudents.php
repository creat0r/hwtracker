<?php //welcome/views/teacher/allstudents.php ?>

<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'First Name');
        data.addColumn('string', 'Last Name');
        data.addColumn('number', 'Number of Homework Missed');
        data.addRows([
     <?php
        foreach($allmystudents as $hw)
        {
            if($hw['COUNT(studentid)']>0)
            {// since there is record, show the link
                echo "['<a href=\"".site_url()."/welcome/teacher/studentrecord/".$hw['studentid']."\"data-ajax=\"false\">".$hw['first_name']."</a>', '".$hw['last_name']."',".$hw['COUNT(studentid)']."],";
       
            }
            else
            { // no record no link
                echo "['".$hw['first_name']."</a>', '".$hw['last_name']."',".$hw['COUNT(studentid)']."],";
       
            }
        }
    ?>

        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, allowHtml:true});
      }
    </script>


<script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table, 
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Subject');
    data.addColumn('number', 'Number');
    data.addRows([
    <?php
		foreach($allmystudents as $hw)
    	{
    		echo "['".$hw['first_name']." ".$hw['last_name']."',".$hw['COUNT(studentid)']."],";
    	}
    	?>
    /*['Mathematics', 3],
    ['Science', 1],
    ['Humanities', 1], 
    ['English', 3],
    ['Music', 2]
    */
    ]);

    // Set chart options
    var options = {'title':'Missed Homework',
                 //'width':90%,
                 //'height':300
//setup colors
<?php 
/*
if ($hwtotal['totalmissed']>10)
{
    $colors="'red','#004411'";
}
elseif($hwtotal['totalmissed']>5)
{
    $colors="'orange','#FF6A00'";
}
else
{
    $colors="'yellow','#FFC300'";
}*/
?>
                 colors:['red','#004411']
             };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.BarChart(document.getElementById('subject_div'));
    chart.draw(data, options);
/*
    // by month
    // Create the data table.
    var monthdata = new google.visualization.DataTable();
    monthdata.addColumn('string', 'Month');
    monthdata.addColumn('number', 'Number');
    monthdata.addRows([
    <?php
        foreach($hwdetailsbymonth as $hw)
        {
            echo "['".$hw['month']."',".$hw['totalMissed']."],";
        }
        ?>
    ]);

    // Set chart options
    var monthoptions = {'title':'Missed Homework by Month',
                 //'width':90%,
                 //'height':300
                 //colors:['red','#004411']
                 colors:[<?php echo $colors; ?>]
             };

    // Instantiate and draw our chart, passing in some options.
    var month = new google.visualization.ColumnChart(document.getElementById('month_div'));
    month.draw(monthdata, monthoptions);


    // by week
    // Create the data table.
    var weekdata = new google.visualization.DataTable();
    weekdata.addColumn('string', 'Week');
    weekdata.addColumn('number', 'Number');
    weekdata.addRows([
    <?php
        foreach($hwdetailsbyweek as $hw)
        {
            echo "['".$hw['weekno']."',".$hw['totalMissed']."],";
        }
        ?>
    ]);

    // Set chart options
    var weekoptions = {'title':'Missed Homework by Week',
                 //'width':90%,
                 //'height':300
                 //colors:['red','#004411']
                 colors:[<?php echo $colors; ?>]
             };

    // Instantiate and draw our chart, passing in some options.
    var week = new google.visualization.ColumnChart(document.getElementById('week_div'));
    week.draw(weekdata, weekoptions);
*/
    }
</script>


<?php 
	$this->load->view('teacher/topmenu');
?>
<!--Div that will hold the chart-->
<div id='table_div'></div>

<div id="subject_div" style="width:90%; height:300"></div>
   
<?php
/*
echo "<pre> teacherid: ";
//echo $teacherid;
echo "</pre><br />";
echo "<pre>";
print_r($allmystudents);
echo "</pre>";
*/
?>