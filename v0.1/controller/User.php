<?php

require_once './lib/ApiHelper.php';
require_once './model/User.php';

class UserCtrl {
	public function Init() {
		ApiHelper::MethodSwitch('User');
	}

    // Get multiple users
    public function GETUser() {
        $ApiHelper = new ApiHelper();
        $ApiHelper->Authentication();

        $ApiHelper->HttpResponse('success', 'but endpoint under construction.', null);
    }

	// Get user by Id
	public function GETUserById($param) {
        echo $_GET['param'];
		$ApiHelper = new ApiHelper();
		$ApiHelper->Authentication();

        if (isset($param)) {
            $User = new UserModel();
            $data = $User->GetById($param);
            $ApiHelper->HttpResponse('success', null, $data);
        } else {
            $ApiHelper->HttpResponse('fail', 'invalid id.', null);
        }
	}

    // Register user
	public function POSTUser() {
        $postdata = file_get_contents('php://input');

        $result = json_decode($postdata, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $result = array(
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'email' => $_POST['email']
            );
        }

        if (!isset($result['username']) || !isset($result['password']) || !isset($result['email'])) {
            ApiHelper::HttpResponse('fail', 'require username, password and email.', null);
        } else {
            ApiHelper::HttpResponse('success', null, null);
        }
	}
}