<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;


class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(PinRepository $pinRepository):Response
    {
        $pins= $pinRepository->findBy([],['createdAt'=>'DESC']);
        return $this->render('pins/index.html.twig', compact('pins'));
    }

    /**
     * @Route("/pins/create", name="app_pins_create", methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        $form=$this->createFormBuilder(new Pin)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $data=$form->getData();
            $pin=new Pin;
            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');

        }

        return $this->render('pins/create.html.twig',[
            'form'=>$form->createView()
        ]);
    }    

     /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show", methods="GET")
     */
    public function show(Pin $pin) :Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }
}
