<?php
namespace Library\Repository;
use Library\UserInterface;
use User;
class userRepository implements UserInterface
{
	 public function __construct(User $user)
    {
        $this->user = $user;
    }
    
	public function create($data)
	{
		 return $this->user->create($data);
	}
}
?>