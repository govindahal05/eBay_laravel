<?php
 
namespace Library;
use Illuminate\Support\ServiceProvider;
/**
 * Class UserServiceProvider
 * @package RobustC
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        $this->app->bind('Library\UserInterface', 'Library\Repository\userRepository');
    }
}
