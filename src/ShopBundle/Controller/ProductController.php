<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    public function __construct()
    {
    }

    public function listAction():Response
    {
        return $this->render('@Shop/Product/public/list.html.twig');
    }

}
