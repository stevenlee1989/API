<?php

class UserModel {
	protected $data;

	public function GetById($id) {
	    $user = array(
	        'id' => $id,
	        'firstName' => 'Leng Caia',
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

	    return $user;
	}
}