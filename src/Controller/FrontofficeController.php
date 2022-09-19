<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontofficeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PlatRepository $platRepository): Response
    {
        $plats = $platRepository->findAll();

        return $this->render('frontoffice/index.html.twig', [
            'controller_name' => 'FrontofficeController',
            'plats' => $plats
        ]);
    }

    /**
     * @Route("/plat/{id<[0-9]+>}", name="app_show")
     */
    public function show(Plat $plat): Response
    {
        return $this->render('frontoffice/show.html.twig', [
            'controller_name' => 'FrontofficeController',
            'plat' => $plat
        ]);
    }
}
