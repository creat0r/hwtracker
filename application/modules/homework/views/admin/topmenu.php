<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('homework/admin/index')?>">
    <?php print $this->bep_assets->icon('sum');?>
    <?php print "Total"; ?>
    </a>
	<a href="<?php print  site_url('homework/admin/show_month/this_month')?>">
    <?php print $this->bep_assets->icon('calendar');?>
    <?php print "This Month"; ?>
    </a>
    <a href="<?php print  site_url('homework/admin/show_month/last_month')?>">
    <?php print $this->bep_assets->icon('calendar');?>
    <?php print "Last Month"; ?>
    </a>
    <a href="<?php print  site_url('homework/admin/show_week/this_week')?>">
    <?php print $this->bep_assets->icon('calendar_view_week');?>
    <?php print "This Week"; ?>
    </a>
    <a href="<?php print  site_url('homework/admin/show_week/last_week')?>">
    <?php print $this->bep_assets->icon('calendar_view_week');?>
    <?php print "Last Week"; ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>