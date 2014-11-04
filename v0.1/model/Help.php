<?php

class HelpModel {

	protected $data = array('endpoints' => array(
			            array(
			                'name' => 'register',
			                'desc' => 'for creating user account, should be private.',
			                'url' => 'api/v0/user/',
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
			                'name' => 'user by id',
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

	public function Get() {
		return $this->data;
	}
}