<?php

SwitchController();

function Register() {

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

        if (!isset($result['username']) || !isset($result['password']) || !isset($result['email'])) {
            HttpResponse('fail', 'require username, password and email.', null);
        } else {
            HttpResponse('success', null, null);
        }
    } else {
        HttpResponse('fail', 'only \'POST\' method acceptable.', null);
    }
}

function SwitchController() {
    // echo strtolower($_GET['ctrl']);
    // echo $_GET['param'];
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

function HttpResponse($status, $message, $data) {
    $processedMessage = $status . (isset($message) ? ', ' . $message : '');
    $response = array(
            'message' => $processedMessage,
            'data' => $data
        );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function User() {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (Authentication()) {
            if (isset($_GET['param'])) {
                $data = LoadUser($_GET['param']);
                HttpResponse('success', null, $data);
            } else {
                HttpResponse('fail', 'invalid id.', null);
            }
        } else {
            HttpResponse('fail', 'unauthorize.', null);
        }
    } else {
        HttpResponse('fail', 'only \'GET\' method acceptable.', null);
    }
}

function LoadUser($id) {
    $user = array(
        'id' => $id,
        'firstName' => 'Leng Cai',
        'lastName' => 'Me',
        'username' => 'test',
        'createdDate' => 1272509157,
        'expiryDate' => 1272509157,
        'contact' => array(
            'work' => '+60161234567',
            'home' => '+60161234567',
            'mobile' => '+60161234567'
        ),
        'email' => 'test@test.com',
        'address' => 'somewhere in the forest',
        'photo' => 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSegA_tvaDJtKEexCmoBzFa4nmliNySLfjp84ToSarulpGZEVwdyw'
    );

    //var_dump($user);

    return $user;
}

function Authentication() {
    $headers = apache_request_headers();
    if(isset($headers['Authorization'])){
        return ($headers['Authorization'] == 'SomeRandomGeneratedCharacters');
    }

    return false;
}

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

function Help() {
    $data = array('endpoints' => array(
            array(
                'name' => 'register',
                'desc' => 'for registration',
                'url' => 'api/v0/register/',
                'method' => 'post',
                'param' => array(
                    'username', 'password', 'email'
                ),
                'response' => array(
                    'message' => 'success/fail'
                )
            ),
            array(
                'name' => 'login',
                'desc' => 'for user login',
                'url' => 'api/v0/login/',
                'method' => 'post',
                'param' => array(
                    'username', 'password', 'email'
                ),
                'response' => array(
                    'message' => 'success/fail',
                    'data' => array(
                        'key' => 'SomeRandomGeneratedCharacters'
                    )
                )
            ),
            array(
                'name' => 'user',
                'desc' => 'get user info',
                'url' => 'api/v0/user/{id}',
                'method' => 'get',
                'param' => 'id',
                'response' => array(
                    'message' => 'success/fail',
                    'data' => array(
                        'id' => 888,
                        'firstName' => 'Leng Cai',
                        'lastName' => 'Me',
                        'username' => 'test',
                        'createdDate' => 1272509157,
                        'expiryDate' => 1272509157,
                        'contact' => array(
                            'work' => '+60161234567',
                            'home' => '+60161234567',
                            'mobile' => '+60161234567'
                        ),
                        'email' => 'test@test.com',
                        'address' => 'somewhere in the forest',
                        'photo' => 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcSegA_tvaDJtKEexCmoBzFa4nmliNySLfjp84ToSarulpGZEVwdyw'
                    )
                )
            )
        )
    );

    HttpResponse('success', null, $data);
}
