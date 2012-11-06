<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('auth/admin/members/form')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_add')." Teacher"; ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>

<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'First Name');
        data.addColumn('string', 'Last Name');
        data.addColumn('string', 'School');
        //data.addColumn('number', '');
        data.addRows([
	<?php
        if(count($items))
        {
            foreach($items as $item)
            {
                echo "['".$item['first_name']."', '".$item['last_name']."', '".strtoupper($item['school'])."'],";
            }
        }	
	?>

/*
          ['Mike', 5],
          ['Jim',  2],
          ['Alice', 1],
          ['Bob',  4]*/

        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, allowHtml:true});
      }
    </script>
 <div id='table_div'></div>



<?php

echo "<pre>items ";
print_r($items);
echo "</pre>";

?>