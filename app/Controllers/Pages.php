<?php

namespace Controllers;

use Libraries\Controller;

class Pages extends Controller
{
    public function __construct()
    {
        // echo 'Pages controller loaded';
    }

    /**
     * redirects main controller to the posts
     * @return void
     */
    public function index(): void
    {
        redirect('posts');
    }

}
