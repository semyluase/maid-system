<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use Illuminate\Support\ServiceProvider;

class BroadcastMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $mail = EmailConfiguration::configuredEmail('broadcast')->first();

        if (isset($mail->id)) {
            $config = array(
                'driver'     => $mail->driver,
                'host'       => $mail->host,
                'port'       => $mail->port,
                'from'       => array('address' => $mail->address, 'name' => $mail->name),
                'encryption' => $mail->encryption,
                'username'   => $mail->username,
                'password'   => $mail->password
            );

            \Config::set('mail', $config);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
