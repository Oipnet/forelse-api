<?php

namespace App\Contracts;

interface SenderInterface
{
    public function send($from, $to, $subject, $message);
}