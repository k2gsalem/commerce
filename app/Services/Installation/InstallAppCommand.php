<?php

namespace App\Services\Installation;

/**
 * Class InstallAppCommand.
 */
class InstallAppCommand
{
    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $password_confirmation;

    /**
     * InstallAppCommand constructor.
     *
     * @param $name
     * @param $email
     * @param $password
     * @param $password_confirmation
     */
    public function __construct(
        $name = 'admin',
        $email = 'admin@gmail.com',
        $password = '12345678',
        $password_confirmation = '12345678'
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }
}
