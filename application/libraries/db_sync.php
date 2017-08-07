<?php

class Db_sync {

	private $sync_folder = FCPATH . "/db_sync/";

    function __construct() {
        $this->CI =& get_instance();
    }

    function dump() {
        $this->create_config();

	    $file_name = 'dbsync.zip';
	    $file = FCPATH . '/upload/' . $file_name;

        $this->zip_folder($file);

		header('Content-Description: File Transfer');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename=' . $file_name);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
	    chmod($file, 0777);
		@unlink($file);
		readfile().exit;
    }

    function create_config() {
    	$this->CI->config->load('dbsync');
        $dbsync = $this->CI->config->item('dbsync');
        extract($dbsync);

    	$db_config_file = fopen($this->sync_folder . "dbsync.ini", "w") or die("Unable to open file!");
		$txt = "user=" . $source_user . "\n";
		$txt .= "password=" . $source_password . "\n";
		$txt .= "target.user=" . $target_user . "\n";
		$txt .= "target.password=" . $target_password . "\n";
		fwrite($db_config_file, $txt);
		fclose($db_config_file);

        $tables = $this->CI->db->list_tables();

        if (count($tables) > 0) {
		   	$run_file = fopen($this->sync_folder . "run.bat", "w") or die("Unable to open file!");
		   	$txt = '';
			foreach ($tables as $table) {
				if (in_array($table, $skip_tables)) {
					continue;
				}
				$txt .= "php db-sync.phar " . $source_ip . " " . $target_ip . " " . $source_db . "." . $table . " --target.table " . $target_db . "." . $table . " -e --delete\n";
			}
			fwrite($run_file, $txt);
			fclose($run_file);
        }
    }

    function zip_folder($fileName) {
    	// Get real path for our folder
		$rootPath = realpath($this->sync_folder);

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();
    }

}