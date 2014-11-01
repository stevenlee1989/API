<?php
//echo 'loader';
class ApiHelper {
    public function ControllerSwitch() {
	    if (isset($_GET['ctrl'])) {
	        switch(strtolower($_GET['ctrl'])) {
	            case 'register': 
	                Register(); 
	                break;
	            case 'login': 
	                Login(); 
	                break;
	            case 'help': 
	                Help(); 
	                break;
	            case 'user':
	                User();
	                break;
	            default : 
	                HttpResponse('fail', 'invalid endpoint', null);
	        }
	    } else {
	        HttpResponse('fail', 'invalid endpoint', null);
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
	    exit();
	}
}