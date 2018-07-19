<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 17/07/2018
 * Time: 13:44
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends Controller
{
    /**
     * @return Response
     * @Route("/hello/{name}", name="app_hello"))
     * @Template("helloWorld/helloWorld.html.twig")
     */

    public function hello($name="World") {
        return ["user_name" => $name];
    }

}