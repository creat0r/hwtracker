<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('auth/admin/members/form')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_add')." Student"; ?>
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
        data.addColumn('string', 'email');
        data.addColumn('string', 'Parent email 1');
        data.addColumn('string', 'Parent email 2');
        data.addColumn('string', 'Advisor');
        data.addColumn('string', 'Active');
        data.addColumn('string', 'Edit');
        //data.addColumn('number', '');
        data.addRows([
	 <?php
   if(count($items))
   {
        foreach($items as $item)
        {
            foreach($advisors as $key=>$advisor)
            {
                if($item['advisor']==$advisor['id'])
                {
                    $ad=$advisor['last_name'];
                }
            }
            $active_icon = ($item['active']=='1'?'tick':'cross');
            $editlink = anchor('auth/admin/members/form/'.$item['id'],$this->bep_assets->icon('pencil'));
            echo "['".$item['first_name']."', '".$item['last_name']."', '".$item['email']
            ."', '".$item['parent_email1']."', '".$item['parent_email2']."', '".$ad."', '".$this->bep_assets->icon($active_icon)."','".$editlink."'],";
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
/*
echo "<pre>items ";
print_r($items);
echo "</pre>";
echo "<pre>advisors ";
print_r($advisors);
echo "</pre>";
*/

?>