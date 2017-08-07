<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mysqlautobackup
{

    function __construct()
    {
        $this->CI =& get_instance();
    }

    public function index($output = false)
    {
        $this->CI->config->load('mysqlautobackup');
        $mysqlautobackup = $this->CI->config->item('mysqlautobackup');
        extract($mysqlautobackup);
        /*******************************************************************************************
         * phpMySQLAutoBackup
         ********************************************************************************************/
        $phpMySQLAutoBackup_version = "1.6.2";
        // ---------------------------------------------------------
        if (($db == "") OR ($mysql_username == ""))/*OR($mysql_password=="")*/ {
            echo "Configure your installation BEFORE running, add your details to the file mysqlautobackup.php";
            exit;
        }

        $backup_type = "\n\n BACKUP Type: Full database backup (all tables included)\n\n";
        if (isset($table_select)) {
            $backup_type = "\n\n BACKUP Type: partial, includes tables:\n";
            foreach ($table_select as $key => $value) $backup_type .= "  $value;\n";
        }
        if (isset($table_exclude)) {
            $backup_type = "\n\n BACKUP Type: partial, EXCLUDES tables:\n";
            foreach ($table_exclude as $key => $value) $backup_type .= "  $value;\n";
        }
        $errors = "";
        include(APPPATH . "libraries/mysqlautobackup/mysqlautobackup_extras.php");
        include(APPPATH . "libraries/mysqlautobackup/schema_for_export.php");
        $backup_info = "\n\n";

        $backup_info .= $backup_type;

        $backup_info .= $recordBackup->get();

        // zip the backup and email it
        $backup_file_name = 'mysql_' . $db . strftime("_%d_%b_%Y_time_%H_%M_%S.sql", time()) . '.gz';
        $dump_buffer = gzencode($buffer);

        if ($output) {
            $save_backup_zip_file_to_server = 0;
            output_backup($dump_buffer, $backup_file_name);
        }

        if ($save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);

        //FTP backup file to remote server
        if (isset($ftp_username)) {
            //write the backup file to local server ready for transfer if not already done so
            if (!$save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);
            $transfer_backup = new transfer_backup();
            $errors .= $transfer_backup->transfer_data($ftp_username, $ftp_password, $ftp_server, $ftp_path, $backup_file_name);
            if (!$save_backup_zip_file_to_server) unlink(FCPATH . "/backups/" . $backup_file_name);
        }

        if (!session_id()) session_start();
        if (isset($_SESSION['pmab_mysql_errors'])) $errors .= $_SESSION['pmab_mysql_errors'];

        if ($send_email_backup) xmail($to_emailaddress, $from_emailaddress, "phpMySQLAutoBackup: $backup_file_name", $dump_buffer, $backup_file_name, $backup_type, $phpMySQLAutoBackup_version);
        if ($send_email_report) {
            $msg_email_backup = "";
            $msg_ftp_backup = "";
            $msg_local_backup = "";
            if ($send_email_backup) $msg_email_backup = "\nthe email with the backup attached has been sent to: $to_emailaddress \n";
            if (isset($ftp_username)) $msg_ftp_backup = "\nthe backup zip file has been transferred via ftp to: $ftp_server (user: $ftp_username) - folder: $ftp_path \n";
            if ($save_backup_zip_file_to_server) $msg_local_backup = "\nthe backup zip file has been saved to the same server: " . dirname(__FILE__) . "/backups/ \n";
            if ($errors == "") $errors = "None captured.";
            mail($report_emailaddress,
                "REPORT on recent backup using phpMySQLAutoBackup ($backup_file_name)",
                "ERRORS: $errors \nSAVE or DELETE THIS MESSAGE - no backup is attached $msg_email_backup $msg_ftp_backup $msg_local_backup \n$backup_info \n phpMySQLAutoBackup (version $phpMySQLAutoBackup_version) is developed by http://www.dwalker.co.uk/ \nPlease consider making a donation at:\n http://www.dwalker.co.uk/make_a_donation.php \n(every penny or cent helps)",
                "From: $from_emailaddress\nReply-To:$from_emailaddress");
        }

        if (DEBUG) echo '<H1>WARNING: DEBUG is on! To turn off edit run.php and set DEBUG to 0 (zero)</H1>Report below:<br><textarea cols=150 rows=50>' . "\n\nERRORS: " . $errors . $backup_info . '</textarea>';
    }
}

/* End of file Mysqlautobackup.php */