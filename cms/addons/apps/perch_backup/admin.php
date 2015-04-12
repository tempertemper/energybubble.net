<?php
	
    if ($CurrentUser->logged_in() && $CurrentUser->has_priv('perch_backup')) {
       $this->register_app('perch_backup', 'Backup', 10, 'Backup your Perch data and customizations');
	   $this->add_setting('perch_backup_mysqldump_path', 'Path to mysqldump', 'text');
    }

    
?>