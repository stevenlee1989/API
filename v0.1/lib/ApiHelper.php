<?php

Class ApiHelper {
    public function ControllerSwitch() {
    	self::Autoloader();

	    if (isset($_GET['ctrl'])) {
	        switch(strtolower($_GET['ctrl'])) {
	            case 'login': 
	                LoginCtrl::Init(); 
	                break;
	            case 'help': 
	                HelpCtrl::Init(); 
	                break;
	            case 'user':
	                UserCtrl::Init();
	                break;
	            default : 
	                self::HttpResponse('fail', 'invalid endpoint', null);
	        }
	    } else {
	        self::HttpResponse('fail', 'invalid endpoint', null);
	    }
	}

	public function test() {
		return "Test function called";
	}

	public function MethodSwitch($Name) {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				self::CallMethod('GET', $Name);
				break;
			case 'POST':
				self::CallMethod('POST', $Name);
				break;
			case 'PUT':
				self::CallMethod('PUT', $Name);
				break;
			case 'DELETE':
				self::CallMethod('DELETE', $Name);
				break;
			default:
				self::HttpResponse('fail', 'invalid method.', null);
		}
	}

    public function HttpResponse($status, $message, $data) {
	    $processedMessage = $status . (isset($message) ? ', ' . $message : '');
	    $response = array(
	            'message' => $processedMessage,
	            'data' => $data
	        );
	    
	    header('Content-Type: application/json');
	    echo json_encode($response);
	}

	public static function Autoloader() {
		foreach (glob("./controller/*.php") as $filename) {
		    require_once $filename;
		}
	}

	private static function CallMethod($Method, $Name) {
		$CtrlName = $Name . 'Ctrl';
		$MethodName = $Method . $Name;
		$CtrlName::$MethodName();
	}

}