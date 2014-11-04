<?php

require_once 'lib/ApiHelper.php';

ApiHelper::ControllerSwitch();

function Login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            HttpResponse('fail', 'require username or email.', null);
        } elseif (!isset($result['password'])) {
            echo $result['password'];
            HttpResponse('fail', 'require password.', null);
        } else {
            //echo isset($username);
            //echo isset($password);
            if (isset($username) && isset($password)) {
                //echo 'username';
                LoginResponse($username == 'test' && $password == 'password');
            } elseif (isset($email) && isset($password)) {
                //echo 'pas';
                LoginResponse($email == 'test@test.com' && $password == 'password');
            } else {
                //echo 'fail';
                LoginResponse(false);
            }
        }
    } else {
        HttpResponse('fail', 'only \'POST\' method acceptable.', null);
    }
}

function LoginResponse($success) {
    if ($success == true) {
        $data = array('key' => 'SomeRandomGeneratedCharacters');
        HttpResponse('success', null, $data);
    } else {
        HttpResponse('fail', 'invalid username or password', null);
    }
    
}


