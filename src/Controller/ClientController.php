<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route ("/client/create", name="create_client")
     */
    public function ajouterClient(Request $request, EntityManagerInterface $em){


        $client = new Client();

        $form=$this->createForm(ClientType::class);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $client = $form->getData();
            $this->em = $em;
            $this->em->persist($client);
            $this->em->flush();
            dump($client);

            return $this->redirectToRoute('app_client');

        }
        return $this->render('client/NewClient.html.twig',
            ['formClient'=> $form->createView()]);
    }

    /**
     * @Route("/client", name="app_client")
     */
    public function index( ClientRepository $repo): Response
    {
        $clients = $repo->findAll();

        return $this->render('client/ListeClient.html.twig', [
            'controller_name' => 'ClientController',
            'clients'  => $clients
        ]);
    }
    /**
     * @Route ("/client/{id}", name="client_id")
     */
    public function clientid(ClientRepository $repo,$id,Request $request,EntityManagerInterface $em){
        $client = $repo->find($id);
        $form=$this->createForm(ClientType::class,$client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $client = $form->getData();
            $this->em = $em;
            $this->em->persist($client);
            $this->em->flush();
            dump($client);

            return $this->redirectToRoute('app_client');

        }
        return $this->render('client/clientid.html.twig',[
            'formc'  => $form->createView(),
            'client' => $client
        ]);
    }


    /**
     * @Route ("/client/remove/{id}", name="remove_client")
     */
    public function RemoveClient(ClientRepository $repo,$id,Request $request,EntityManagerInterface $em){
        $client = $repo->find($id);
        foreach ( $client->getAddresses() as $add){
            $this->em = $em;
            $this->em->remove($add);
            $this->em->flush();

        }




        $this->em = $em;
        $this->em->remove($client);
        $this->em->flush();
        dump($client);

        return $this->redirectToRoute('app_client');


    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {

        return $this->render('home.html.twig');
    }

}
