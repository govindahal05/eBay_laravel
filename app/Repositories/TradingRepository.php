<?php
class TradingRepository{

	public function __construct(User $user){
		$this->user = $user;
	}

	public function all(){
		return $this->user->all();
	}
}