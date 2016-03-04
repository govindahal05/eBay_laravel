<?php
class Authentication {
	/**
	 * @param $rules
	 */
	public function authenticate($rules) {
		$authentication = \Auth::attempt($rules);
		if ($authentication) {
			//return $validation->messages();
			return true;
		}
		return false;
	}
}