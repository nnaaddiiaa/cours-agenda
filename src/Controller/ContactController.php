<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_list")
     */
    public function listContact(): Response
    {
        //$contacts= $this->getDoctrine()->getRepository(Contact::class)->find($id);
        //$contacts= $this->getDoctrine()->getRepository(Contact::class)->findAll();
        // $contacts= $this->getDoctrine()->getRepository(Contact::class)->findBy(['nom' => 'dupont']);
        // $contact= $this->getDoctrine()->getRepository(Contact::class)->findOneBy(['nom' => 'dupont']);
        
        $contacts= $this->getDoctrine()->getRepository(Contact::class)->findByOlderThan(30);

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/add", name="add");
     */
    public function add()
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $contact = new Contact;
        $contact->setNom("toto");
        $contact->setPrenom("tata");
        $contact->setTelephone("1234567891");

        $contact2 = new Contact;
        $contact2->setNom("dupont");
        $contact2->setPrenom("martin");
        $contact2->setTelephone("1234567891");

        $entityManager->persist($contact);
        $entityManager->persist($contact2);
        $entityManager->flush();
        
        return $this->redirectToRoute('contact_list');
    }

    /**
     * @Route("/contact/show/{id}", name="contact_show");
     */
    public function show($id)
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);        
        
        return $this->render('show.html.twig', [
            'contact' => $contact
        ]);
    }

     /**
     * @Route("/contact/edit/{id}", name="contact_edit")
     */
    public function editContact($id): Response
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
       
        $contact->setNom('pierre');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        
        return $this->redirectToRoute('contact_list');
    }

     /**
     * @Route("/delete/{id}", name="contact_delete");
     */
    public function delete($id)
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute('contact_list');
    }

}
