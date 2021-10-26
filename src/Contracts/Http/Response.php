<?php

namespace App\Contracts\Http;

interface Response
{
    public function send(): void;
}
