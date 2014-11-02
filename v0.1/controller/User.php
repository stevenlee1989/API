<?php

require_once './lib/ApiHelper.php';
//require_once './model/Help.php';

class UserCtrl {
	public function Init() {
		ApiHelper::MethodSwitch('User');
	}

	// TODO
	public function GETUser() {
		$data = new HelpModel();
	    ApiHelper::HttpResponse('success', null, $data->Get());
	}

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