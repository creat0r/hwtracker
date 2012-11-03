<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('subjects/admin/create')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_add')." Subject"; ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>


<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Subject Name');
        data.addColumn('string', 'Status');
        data.addColumn('string', 'Action');
        data.addRows([
	 <?php
		foreach($items as $item)
    	{
        $active_icon = ($item['status']=='active'?'tick':'cross');
        $statuslink = anchor("kaimonokago/admin/changeStatus/subjects/".$item['id'],$this->bep_assets->icon($active_icon), array('class' => $item['status']. ' changestatus'));
        $editlink = anchor($module.'/admin/edit/'.$item['id'],$this->bep_assets->icon('pencil'));
         if ($item['status']=='inactive')
            {
                $deletelink = anchor('kaimonokago/admin/delete/subjects/'.$item['id'],$this->bep_assets->icon('delete'), array("class" => "delete_link","onclick"=>"return confirmSubmit(\"".$item['name']."\")"));
            }
            else
            {
                $deletelink ='';
            }
          //$link = "testing";  
    		echo "['".$item['name']."','".$statuslink."','".$editlink.$deletelink."' ],\n";
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