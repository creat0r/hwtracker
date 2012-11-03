<div id="generatePasswordWindow">
	<table>
		<tr><th width="50%"><?php print $this->lang->line('userlib_generate_password'); ?></th><th class="right"><a href="javascript:void(0);" id="gpCloseWindow"><?php print $this->bep_assets->icon('cross') ?></a></th></tr>
		<tr><td rowspan="3"><?php print $this->lang->line('userlib_password'); ?>:<br/>&nbsp;&nbsp;&nbsp;<b id="gpPassword">PASSWORD</b></td><td class="right"><?php print $this->lang->line('general_uppercase'); ?> <?php print form_checkbox('uppercase','1',TRUE); ?></td></tr>
		<tr><td class="right"><?php print $this->lang->line('general_numeric'); ?> <?php print form_checkbox('numeric','1',TRUE); ?></td></tr>
		<tr><td class="right"><?php print $this->lang->line('general_symbols'); ?> <?php print form_checkbox('symbols','1',FALSE); ?></td></tr>
		<tr><td colspan="2"><a href="javascript:void(0);" class="icon_arrow_refresh" id="gpGenerateNew"><?php print $this->lang->line('general_generate'); ?></a></td></tr>
		<tr><td><a href="javascript:void(0);" class="icon_tick" id="gpApply"><?php print $this->lang->line('general_apply'); ?></a></td><td class="right"><?php print $this->lang->line('general_length'); ?> <input type="text" name="length" value="12" maxlength="2" size="4" /></td></tr>
	</table>
</div>

<h2><?php print $header?></h2>
<p><?php print $this->lang->line('userlib_password_info')?></p>

<?php print form_open('auth/admin/members/form/'.$this->form_validation->id,array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <?php print form_label($this->lang->line('userlib_username'),'username')?>
                <?php print form_input('username',set_value('username',$this->form_validation->username),'id="username" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_email'),'email')?>
                <?php print form_input('email',set_value('email',$this->form_validation->email),'id="email" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_password'),'password')?>
                <?php print form_password('password',NULL,'id="password" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_confirm_password'),'confirm_password')?>
                <?php print form_password('confirm_password',NULL,'id="confirm_password" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_group'),'group')?>
                <?php print form_dropdown('group',$groups,set_value('group',$this->form_validation->group),'id="group" size="10" style="width:20.3em;"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_active'),'active')?>
                <?php print $this->lang->line('general_yes')?> <?php print form_radio('active','1',set_radio('active','1',$selected = ($this->form_validation->active == 1) ? TRUE : FALSE),'id="active"')?>
                <?php print $this->lang->line('general_no')?> <?php print form_radio('active','0',set_radio('active','0',$selected = ($this->form_validation->active == 1) ? FALSE : TRUE))?>
            </li>
            <li class="submit">
                <?php print form_hidden('id',set_value('id',$this->form_validation->id))?>
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/members')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>

	                <a href="javascript:void(0);" id="generate_password">
	                	<?php print  $this->bep_assets->icon('key');?>
	                	<?php print $this->lang->line('userlib_generate_password'); ?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<h2><?php print $this->lang->line('userlib_user_profile')?></h2>
<?php
    if( ! $this->preference->item('allow_user_profiles')):
        print "<p>".$this->lang->line('userlib_profile_disabled')."</p>";
    else:
?>
    <fieldset>
        <ol>
            <li>
                <?php print form_label('First Name','first_name')?>
                <?php $value = (empty($profiles['first_name']))? '' : $profiles['first_name'];  ?>
                <?php print form_input('first_name',$value,'id="first_name" class="text"')?>
 
            </li>
            <li>
                <?php print form_label('Last Name','last_name')?>
                 <?php $value = (empty($profiles['last_name']))? '' : $profiles['last_name'];  ?>
                <?php print form_input('last_name',$value,'id="last_name" class="text"')?>
            </li>
            <li>
                <?php print form_label('Parent email 1','parent_email1')?>
                 <?php $value = (empty($profiles['parent_email1']))? '' : $profiles['parent_email1'];  ?>
                <?php print form_input('parent_email1',$value,'id="parent_email1" class="text"')?>
            </li>
            <li>
                <?php print form_label('Parent email 2','parent_email2')?>
                 <?php $value = (empty($profiles['parent_email2']))? '' : $profiles['parent_email2'];  ?>
                <?php print form_input('parent_email2',$value,'id="parent_email2" class="text"')?>
            </li>
            <li>
                <?php print form_label('Advisor','advisor')?>
                 <?php $value = (empty($profiles['advisor']))? '' : $profiles['advisor'];  ?>
                <?php print form_input('advisor',$value,'id="advisor" class="text"')?>
            </li>
            <li>
                <?php print form_label('Gender','gender')?>
                Male <?php print form_radio('gender','male',$this->form_validation->set_radio('gender','male',$selected = ($this->form_validation->gender == 'male') ? TRUE : FALSE))?>
                Female <?php print form_radio('gender','female',$this->form_validation->set_radio('gender','female',$selected = ($this->form_validation->gender == 'male') ? FALSE : TRUE))?>
            </li>
            <li>
                <?php print form_label('Admin','role')?>
                ES Principal <?php print form_radio('role','es_principal',$this->form_validation->set_radio('role','es_principal',$selected = ($this->form_validation->role == 'es_principal') ? TRUE : FALSE))?>
                MS Principal <?php print form_radio('role','ms_principal',$this->form_validation->set_radio('role','ms_principal',$selected = ($this->form_validation->role == 'ms_principal') ? TRUE : FALSE))?>
                HS Principal <?php print form_radio('role','hs_principal',$this->form_validation->set_radio('role','hs_principal',$selected = ($this->form_validation->role == 'hs_principal') ? TRUE : FALSE))?>
                None <?php print form_radio('role','none',$this->form_validation->set_radio('role','none',$selected = ($this->form_validation->role == 'none') ? TRUE : FALSE))?>
            
            </li>             

           
            <li class="submit">
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/members')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<?php endif;?>
<?php print form_close()?>


