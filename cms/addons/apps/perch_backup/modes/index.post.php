<?php
    
    # Side panel
    echo $HTML->side_panel_start();
    echo $HTML->heading3('We can backup');
    
    echo $HTML->success_message('Files');
    
    if($Backup->can_mysqldump($mysqldump_path)) {
    	echo $HTML->success_message('MySQL Database');
    }else{
    	echo $HTML->failure_message('MySQL Database');
    }
    echo $HTML->side_panel_end();
    
    
    # Main panel
    echo $HTML->main_panel_start();
    include('_subnav.php');

    echo $HTML->heading1('Making a Backup');


    echo $HTML->heading2('Backup your Perch data and customizations');
    echo '<div id="template-help">';
    echo $HTML->para('Use the form below to backup your Perch data, data and customizations or the entire perch directory.');
	echo $HTML->para('We do not backup your site files - just the perch directory or specified content. The checks on the left will show if we can also backup your MySQL database. If we cannot you will need to do this another way as all Perch data is stored in the database.');
    echo '</div>';
    echo $HTML->heading2('Select backup type and download backup');
    echo $Form->form_start();
	
    $opts = array();
	$opts[] = array('label'=>'Backup resources only', 'value'=>'resources');
	$opts[] = array('label'=>'Backup resources and customizations', 'value'=>'custom');
	$opts[] = array('label'=>'Backup entire Perch directory', 'value'=>'perch');

	echo $Form->select_field('backup_type', 'Backup Type', $opts);
    
	echo $Form->submit_field('btnSubmit', 'Create backup');
	echo $Form->form_end();
    echo $HTML->main_panel_end();


?>