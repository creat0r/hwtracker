<?php $this->load->view('admin/topmenu'); ?>

<?php if (!empty($hwall)): ?>
<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'First Name');
        data.addColumn('string', 'Last Name');
        data.addColumn('number', 'Number of Homework Missed');
        data.addColumn('string', 'Advisor');
        //data.addColumn('string', 'Advisor');
        data.addRows([
	<?php
        if(count($hwall))
        {
            foreach($hwall as $hw)
            {
                foreach($advisors as $key=>$advisor)
                {
                    if($hw['advisor']==$advisor['id'])
                    {
                        $ad=$advisor['last_name'];
                    }
                }
                echo "['<a href=\"".site_url()."/homework/admin/student/".$hw['studentid']."\">".$hw['first_name']
                ."</a>', '".$hw['last_name']."',".$hw['COUNT(studentid)'].", '".$ad."'],";
            }
        }	
	?>
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, allowHtml:true});
      }
    </script>
 <div id='table_div'></div>
<?php else: ?>
	<h3>No data at the moment</h3>
<?php endif; ?>



<?php
/*
echo "<pre>";
print_r($hwall);
echo "</pre>";
*/
?>