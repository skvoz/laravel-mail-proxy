<?php

namespace App\Providers;

use App\Domain\Email\Email;
use App\Domain\Email\EmailRepository;
use App\Domain\Users\Users;
use App\Domain\Users\UsersRepository;
use App\Infrastructure\Email\DoctrineEmailRepository;
use App\Infrastructure\Users\DoctrineUsersRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(EmailRepository::class, function($app){
            return new DoctrineEmailRepository(
                $app['em'],
                $app['em']->getClassMetaData(Email::class)
            );
        });

        $this->app->bind(UsersRepository::class, function($app){
            return new DoctrineUsersRepository(
                $app['em'],
                $app['em']->getClassMetaData(Users::class)
            );
        });
    }
}


