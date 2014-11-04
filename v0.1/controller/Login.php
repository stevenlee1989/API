<?php

require_once './lib/ApiHelper.php';

class LoginCtrl {
	public function Init() {
		ApiHelper::MethodSwitch('Login');
	}

	public function POSTLogin() {
		$ApiHelper = new ApiHelper();
        $ApiHelper->Authentication();

        $postdata = file_get_contents('php://input');
        $result = json_decode($postdata, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $result = array(
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'email' => $_POST['email']
            );
        }

        $username = isset($result['username']) ? $result['username'] : null;
        $email = isset($result['email']) ? $result['email'] : null;
        $password = isset($result['password']) ? $result['password'] : null;

        if (!isset($username) && !isset($email)) {
            $ApiHelper->HttpResponse('fail', 'require username or email.', null);
        } elseif (!isset($result['password'])) {
            echo $result['password'];
            $ApiHelper->HttpResponse('fail', 'require password.', null);
        } else {
            //echo isset($username);
            //echo isset($password);
            if (isset($username) && isset($password)) {
                //echo 'username';
                self::LoginResponse($username == 'test' && $password == 'password');
            } elseif (isset($email) && isset($password)) {
                //echo 'pas';
                self::LoginResponse($email == 'test@test.com' && $password == 'password');
            } else {
                //echo 'fail';
                self::LoginResponse(false);
            }
        }
	}

	private function LoginResponse($success) {
		$ApiHelper = new ApiHelper();
	    if ($success == true) {
	        $data = array('key' => 'SomeRandomGeneratedCharacters');
	        $ApiHelper->HttpResponse('success', null, $data);
	    } else {
	        $ApiHelper->HttpResponse('fail', 'invalid username or password', null);
	    }
	    
	}
}