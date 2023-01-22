<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
     * @Route("/address/create/C{id}", name="lister_adresse")
     */
    public function AdresseClient( ClientRepository $repo, $id)
    {
        $adresses = $repo->find($id)->getAddresses();
        return $this->render('address/Lister.html.twig', [
            'controller_name' => 'AddressController',
            'Adresses'  => $adresses
        ]);
    }

    /**
     * @Route ("/address/create/{id}", name="create_address")
     */
    public function CreateAddress(ClientRepository $repo,$id,Request $request, EntityManagerInterface $em){

        $address = new Address();




        $form=$this->createForm(AddressType::class);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $client = $repo->find($id);

            $address = $form->getData();
            $address->setClient($client);
            $this->em = $em;
            $this->em->persist($address);
            $this->em->flush();
            dump($address);

            return $this->redirectToRoute('lister_adresse', [
                'id' => $client->getIdclient()]);

        }

        return $this->render('address/NewAddress.html.twig',
            ['formAddress'=> $form->createView()]);
    }

    /**
     * @Route ("/address/consulter/{id}", name="consulter_adress")
     */
    public function ConsulterAdress(AddressRepository $repo,$id,Request $request, EntityManagerInterface $em){

        $adresses = $repo->find($id);





        $form=$this->createForm(AddressType::class,$adresses);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $address = $form->getData();
            $this->em = $em;
            $this->em->persist($address);
            $this->em->flush();
            dump($address);

            return $this->redirectToRoute('lister_adresse', [
                'forma' => $form->createView(),
                'id'=>$adresses->getClient()->getIdclient()]);

        }

        return $this->render('address/modifA.html.twig',
            ['formAddress'=> $form->createView()]);
    }

    /**
     * @Route ("/address/remove/{id}", name="remove_add")
     */
    public function RemoveAdress(AddressRepository $repo,$id,Request $request,EntityManagerInterface $em){
        $adress = $repo->find($id);

        $this->em = $em;
        $this->em->remove($adress);
        $this->em->flush();


        return $this->redirectToRoute('app_client');


    }
    /**
     * @Route("/address/all", name="lister_adresseall")
     */
    public function AdresseAll( AddressRepository $repo)
    {
        $adresses = $repo->findAll();
        return $this->render('address/ListerAll.html.twig', [
            'controller_name' => 'AddressController',
            'Adresses'  => $adresses
        ]);
    }
}
