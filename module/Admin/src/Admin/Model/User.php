<?php

namespace Admin\Model;

class User
{
	public $id;
	public $username;
	public $email;
	public $password;
	public $group;

	public function exchangeArray($data)
	{
		$this->id     	= (!empty($data['id'])) ? $data['id'] : null;
		$this->username = (!empty($data['username'])) ? $data['username'] : null;
		$this->email  	= (!empty($data['email'])) ? $data['email'] : null;
		$this->password = (!empty($data['password'])) ? $data['password'] : null;
		$this->group 	= (!empty($data['group'])) ? $data['group'] : null;
	}
}