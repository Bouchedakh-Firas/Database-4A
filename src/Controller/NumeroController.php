<?php

namespace App\Controller;

use App\Entity\Numero;
use App\Form\NumeroType;
use App\Repository\AddressRepository;
use App\Repository\ClientRepository;
use App\Repository\NumeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NumeroController extends AbstractController
{
    /**
     * @Route("/numero", name="app_numero")
     */
    public function index(NumeroRepository $repo): Response
    {
        $nums = $repo->findAll();
        return $this->render('numero/listerAll.html.twig', [
            'controller_name' => 'NumeroController',
            'numeros' =>$nums
        ]);
    }

    /**
     * @Route("/numero/Client/", name="lister_num")
     */
    public function NumeroClient( NumeroRepository $repo)
    {

        $numeros = $repo->findAll();
        return $this->render('numero/Lister.html.twig', [
            'controller_name' => 'AddressController',
            'numeros'  => $numeros
        ]);
    }

    /**
     * @Route ("/numero/create/{id}", name="create_numero")
     */
    public function CreateNumero(ClientRepository $repo,$id,Request $request, EntityManagerInterface $em){

        $numero = new Numero();




        $form=$this->createForm(NumeroType::class);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $client = $repo->find($id);

            $numero = $form->getData();
            $this->em = $em;
            $this->em->persist($numero);
            $this->em->flush();
            dump($numero);

            return $this->redirectToRoute('lister_num', [
                'id' => $client->getIdclient()]);

        }

        return $this->render('numero/ajouternum.html.twig',
            ['formn'=> $form->createView()]);
    }

    /**
     * @Route ("/numero/remove/{id}", name="remove_num")
     */
    public function RemoveAdress(AddressRepository $repo,$id,Request $request,EntityManagerInterface $em){
        $adress = $repo->find($id);

        $this->em = $em;
        $this->em->remove($adress);
        $this->em->flush();


        return $this->redirectToRoute('app_client');


    }
    /**
     * @Route ("/numero/modifier/{id}", name="consulter_num")
     */
    public function consulterNum(NumeroRepository $repo,$id,Request $request, EntityManagerInterface $em){

        $numero = $repo->find($id);

        dump($numero);


        $form=$this->createForm(NumeroType::class,$numero);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $client = $repo->find($id);

            $numero = $form->getData();
            $this->em = $em;
            $this->em->persist($numero);
            $this->em->flush();
            dump($numero);

            return $this->redirectToRoute('lister_num');

        }

        return $this->render('numero/consulter.html.twig',
            ['formn'=> $form->createView()]);
    }

}
