<?php

namespace Jazz\Demo\Controller;

use Jazz\Controller\Controller;
use Jazz\Demo\Repository\DemoRepository;

class DemoController extends Controller
{
    public function indexAction()
    {
        return $this->render('demo/demo_index.html.twig', array(
            'users' => DemoRepository::getUser($this->app),
        ));
    }
	
	public function showAction()
    {
        return $this->render('demo/demo_index.html.twig', array(
            'users' => DemoRepository::getUser($this->app),
        ));
    }
}