
<?php $this->load->view('admin/topmenu'); ?>

<script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['table, corechart']});
    google.setOnLoadCallback(drawTable);
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table, 
    // instantiates the pie chart, passes in the data and
    // draws it.

    // start of tabel
    function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Subject Name');
        data.addColumn('string', 'Assignment name');
        data.addColumn('string', 'Action');
        data.addRows([
    <?php
        if(count($studenthws))
        {
            foreach($studenthws as $item)
            {
                $item = str_replace("'", "\'", $item);
                //$active_icon = ($item['status']=='active'?'tick':'cross');
                //$statuslink = anchor("kaimonokago/admin/changeStatus/subjects/".$item['id'],$this->bep_assets->icon($active_icon), array('class' => $item['status']. ' changestatus'));
                //$editlink = anchor($module.'/admin/edit/'.$item['id'],$this->bep_assets->icon('pencil'));
                
                $deletelink = anchor("kaimonokago/admin/delete/homework/".$item['id'],$this->bep_assets->icon('delete'), array("class" => "delete_link","onclick"=>"return confirmSubmit(\"".$item['assignment_name']."\")"));
                
                //$link = "testing";  
                echo "['".$item['name']."','".$item['assignment_name']."','".$deletelink."' ],\n";
            }
        }
    ?>

        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, allowHtml:true});
    }
    // end of table

    // Barchart
    function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Subject');
    data.addColumn('number', 'Number');
    data.addRows([
    <?php
		foreach($hws as $hw)
    	{
    		echo "['".$hw['name']."',".$hw['COUNT(hw_homework.id)']."],";
    	}
    	?>
    ]);

    // Set chart options
    var options = {'title':'Missed Homework by Subject',
                 //'width':90%,
                 //'height':300
                 <?php
                    $sub_num=count($hws);
                    $height=$sub_num*50;
                    echo "'height':$height,"
                ?>
//setup colors
<?php 
if ($hwtotal['totalmissed']>=10)
{
    $colors="'red','#004411'";
}
elseif($hwtotal['totalmissed']>=5)
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
        foreach($hwbymonth as $hw)
        {
            echo "['".$hw['month']."',".$hw['totalMissed']."],";
        }
        ?>
    ]);

    // Set chart options
    var monthoptions = {'title':'Missed Homework by Month',
                 //'width':90%,
                 'height':400,
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
        foreach($hwbyweek as $hw)
        {
            echo "['".$hw['weekno']."',".$hw['totalMissed']."],";
        }
        ?>
    ]);

    // Set chart options
    var weekoptions = {'title':'Missed Homework by Week',
                 //'width':90%,
                 'height':400,
                 //colors:['red','#004411']
                 colors:[<?php echo $colors; ?>]
             };

    // Instantiate and draw our chart, passing in some options.
    var week = new google.visualization.ColumnChart(document.getElementById('week_div'));
    week.draw(weekdata, weekoptions);

    }
</script>
<div id="total">
    <h3>TOTAL HOMEWORK MISSED: 
    <?php echo $hwtotal['totalmissed'];?>
    </h3>
</div>
    <div id="table_div"></div>
    <div id="subject_div"></div>
    <div id="month_div"></div>
    <div id="week_div"></div>

<?php
/*
echo "<pre>studenthws ";
print_r($studenthws);
echo "</pre>";
echo "<pre>hws ";
print_r($hws);
echo "</pre>";
echo "<pre>hwbymonth ";
print_r($hwbymonth);
echo "</pre>";
echo "<pre>hwbyweek ";
print_r($hwbyweek);
echo "</pre>";
*/
?>


