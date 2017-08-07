<?php

class Resp {

	public $success = TRUE;
	public $message = '';
	public $details = array();

    function __construct() {
        $this->CI =& get_instance();


    }

	function set_success($success = TRUE) {
		$this->success = $success;
		return $this;
	}

	function set_message($message = '') {
		$this->message = $message;
		return $this;
	}

	function set_details($details = array()) {
		$this->details = $details;
		return $this;
	}

	function output() {
		$result = array(
			'success' => $this->success,
			'message' => $this->message,
			'details' => $this->details
		);

		return $result;
	}

	function output_json() {
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($this->output());
	}

	function return_json() {
		return json_encode($this->output());
	}

    function error_page($text){
            echo '<div class="alert alert-danger" id="error_page" style="margin-top: 10px;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="fa fa-ban-circle"></i><strong>Có l?i ! </strong> '.$text.'.
                  </div>';

    }

}