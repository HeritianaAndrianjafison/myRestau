<?php

namespace App\Controller;

use App\Entity\Plat;
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
     * @Route("/backoffice/newPlat", name="app_newPlat" , methods="GET|POST")
     */
    public function create(Request $request , EntityManagerInterface $em): Response
    {
       $form =  $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class)
            ->add('prix', IntegerType::class)
            ->add('image', TextType::class)
            ->add('categorie', IntegerType::class )
            ->getForm()
        ;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $data= $form->getData();
            $plat = new Plat;
            $plat->setNom($data['nom']);
            $plat->setDescription($data['description']);
            $plat->setPrix($data['prix']);
            $plat->setCategorie($data['categorie']);
            $plat->setImage($data['image']);
            $plat->setNbrVente(0);
            $plat->setDisponible(1);
            $plat->setNote(0);

            $em->persist($plat);
            $em->flush();
        }

        return $this->render('backoffice/newPlat.html.twig', [
            'controller_name' => 'BackofficeController',
            'form' => $form->createView()
        ]);
    }
}
