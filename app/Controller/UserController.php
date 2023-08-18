<?php 

namespace App\Controller;

use App\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class UserController {
    public function create()
    {
        return View::render('users/register');
    }

    public function register()
    {
        //$name = $_POST['name'];
        //$email = $_POST['email'];
        //$name = $_POST['name'];

        $email = (new Email())
                 ->from('projtrac@mail.com')
                 ->to('pwambua25@gmail.com')
                 ->subject('Welcome')
                 ->text('Welcome so and so to this meeting');
        /**
         * DSN - Data Source Name
         * is a string that represents the location where there is a database location, file system location
         * or email transport location
         * smtp://user:pass@smtp.example.com:25
         */
        $dsn = "smtp://ff850dabb5d629:dbb06c86084162@sandbox.smtp.mailtrap.io:2525";
        $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);
        $mailer->send($email);

        return View::render('users/welcome');
    }
}