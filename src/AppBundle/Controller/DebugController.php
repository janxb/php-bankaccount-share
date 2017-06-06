<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DebugController extends Controller
{
    /**
     * @Route("/debug")
     */
    public function indexAction(Request $request)
    {
        return new Response('<div id="foo">foobar</div>');
    }
}
