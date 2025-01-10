<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController {
    public function index(Request $request): Response {
        return new Response('<h1>Bienvenue sur votre nouvelle structure PHP !</h1>');
    }
}
