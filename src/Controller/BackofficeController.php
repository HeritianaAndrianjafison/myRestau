<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackofficeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="app_backoffice" , methods="GET")
     */
    public function index(): Response
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }

    /**
     * @Route("/backoffice/show/{id<[0-9]+>}", name="app_showPlat" , methods="GET")
     */
    public function show(Plat $plat): Response
    {
        return $this->render('backoffice/show.html.twig', [
            'controller_name' => 'BackofficeController',
            'plat' =>  $plat
        ]);
    }

    /**
     * @Route("/backoffice/newPlat", name="app_newPlat" , methods="GET|POST")
     */
    public function create(Request $request , EntityManagerInterface $em): Response
    { 
        $plat = new Plat;
        $form =  $this->createForm(PlatType::class , $plat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $plat= $form->getData();
            $plat->setNbrVente(0);
            $plat->setDisponible(1);
            $plat->setNote(0);

            $em->persist($plat);
            $em->flush();

            return $this->redirectToRoute('app_backoffice');
        }

        return $this->render('backoffice/newPlat.html.twig', [
            'controller_name' => 'BackofficeController',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/backoffice/editPlat/{id<[0-9]+>}", name="app_editPlat" , methods="GET|PUT")
     */
    public function edit(Plat $plat , Request $request ,EntityManagerInterface $em): Response
    {
        $form =  $this->createForm(PlatType::class , $plat , [
            'method' => 'PUT'
        ]);   
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $plat= $form->getData();
            $plat->setNbrVente(0);
            $plat->setDisponible(1);
            $plat->setNote(0);

            $em->flush();

            return $this->redirectToRoute('app_backoffice');
        }

        return $this->render('backoffice/editPlat.html.twig', [
            'controller_name' => 'BackofficeController',
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/backoffice/deletePlat/{id<[0-9]+>}", name="app_deletePlat" , methods="GET|DELETE")
     */
    public function delete(Plat $plat  ,EntityManagerInterface $em): Response
    {
        $em->remove($plat);
        $em->flush();
        return $this->redirectToRoute('app_backoffice');
    }

}
