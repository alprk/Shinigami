<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 20/07/2018
 * Time: 13:33
 */

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/index", name="index", methods={"GET", "POST"})
     */
    public function index()
    {

        return $this->render('base.html.twig');
    }


}