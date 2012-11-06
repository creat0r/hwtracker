<?php if(!$cache): ?>

    <h3>Time has expired</h3>

<?php else: ?>


<script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table, 
    // instantiates the pie chart, passes in the data and    vAxis.gridlines: {color: '#333', count: 4}
    // draws it.
    function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Subject');
    data.addColumn('number', 'Number');
    data.addRows([
    <?php
        foreach($cache['hwdetails'] as $hw)
        {
            echo "['".$hw['name']."',".$hw['COUNT(hw_homework.id)']."],";
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
    var options = {
        'title':'Missed Homework',
        hAxis: {
            //gridlines: {count: 5},
            baseline:0,
        },

    //'hAxis.gridlines.count':'1',
                 //'width':90%,
                 //'height':300
//setup colors
<?php 
if ($cache['hwtotal']['totalmissed']>10)
{
    $colors="'red','#004411'";
}
elseif($cache['hwtotal']['totalmissed']>5)
{
    $colors="'orange','#FF6A00'";
}
else
{
    $colors="'yellow','#FFC300'";
}
?>
                 colors:[<?php echo $colors; ?>]
             };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.BarChart(document.getElementById('subject_div'));
    chart.draw(data, options);

    // by month
    // Create the data table.
    var monthdata = new google.visualization.DataTable();
    monthdata.addColumn('string', 'Month');
    monthdata.addColumn('number', 'Number');
    monthdata.addRows([
    <?php
        foreach($cache['hwdetailsbymonth'] as $hw)
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
        foreach($cache['hwdetailsbyweek'] as $hw)
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

    }
</script>


<!--Div that will hold the pie chart-->
<div id="total">
    <h3>TOTAL HOMEWORK MISSED BY 
    <?php 
    echo $cache['userdetails']['first_name']; 
    echo ": "; 
    echo $cache['hwtotal']['totalmissed'];
    ?>
    </h3>
</div>
    <div id="subject_div" style="width:90%; height:300"></div>
    <div id="month_div" style="width:90%; height:300"></div>
    <div id="week_div" style="width:90%; height:300"></div>



<?php
// endif
    endif;

/*
  echo "<pre>";
  //print_r($hwdetails);
  echo "</pre>";
  foreach($hwdetails as $hw)
  {
    echo $hw['name'].$hw['COUNT(hw_homework.id)'];
  }

*/
  //echo count($hwdetails);
  /*echo "<pre>";
  foreach($hwdetails as $hw)
  {
    print_r ($hw);
  }
  echo "</pre>";
 
echo "<pre>by subject";
print_r($hwdetails);
echo "</pre>";
echo "<pre>by month";
  print_r($hwdetailsbymonth);
echo "</pre>";
echo "<pre>by week";
  print_r($hwdetailsbyweek);
echo "</pre>";
echo "<pre>total";
print_r($hwtotal);
echo "</pre>";
 */
/*
echo "<pre>All by month";
  print_r($hwdetailsbyallmonth);
echo "</pre>";

echo "<pre>All by week";
  print_r($hwdetailsbyallweek);
echo "</pre>";
*/

/*
echo "<pre>";
print_r($cache);
//print_r($plaintext_string);
print_r($encrypted_string);
echo "</pre>";
*/
//print_r($this->cache->get($page));
?>  
