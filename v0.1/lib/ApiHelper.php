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

    public function HttpResponse($status, $message, $data, $code = 200) {
	    $processedMessage = $status . (isset($message) ? ', ' . $message : '');
	    $response = array(
            'message' => $processedMessage,
            'data' => $data
        );
	    
	    header('Content-Type: application/json');
	    http_response_code($code);
	    echo json_encode($response);
	    exit();
	}

	public static function Autoloader() {
		foreach (glob("./controller/*.php") as $filename) {
		    require_once $filename;
		}
	}

	private function CallMethod($Method, $Name) {
		$CtrlName = $Name . 'Ctrl';
		$MethodName = $Method . $Name;

		if (!method_exists($CtrlName, $MethodName)) {
			self::HttpResponse('fail', 'invalid method.', null);
		}
		
		if (isset($_GET['param'])) {
			$MethodName .= 'ById';
			//echo $MethodName;
			//var_dump($_GET['param']);
            $CtrlName::$MethodName($_GET['param']);
        } else {
        	$CtrlName::$MethodName();
        }
	}

	public function Authentication() {
	    $headers = apache_request_headers();
	    if(isset($headers['Authorization'])){
	    	if ($headers['Authorization'] == 'SomeRandomGeneratedCharacters') {
	    		return true;
	    	} 
	    }

	    self::HttpResponse('fail', 'unauthorized.', 401);
	}
}