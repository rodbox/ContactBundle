<?php

namespace RB\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use RB\ContactBundle\Entity\Contact;

/**
 * Contact controller.
 * @Route("api/contact")
 */
class ApiController extends FOSRestController
{
    /**
     * @Route("/add")
     * @Method({"PUT", "POST"})
     */
    public function addAction(Request $request)
    {
        $contactData = $request->request->get("contact");
        $em = $this->getDoctrine()->getManager();
        
        $contact = new Contact();
        $contact->setFirstName($contactData['firstname']);
        $contact->setLastName($contactData['lastname']);
        $contact->setPhone($contactData['phone']);

        $em->persist($contact);
        $em->flush();

        return new JsonResponse([
            'message' => 'contact add'
        ]);
    }

    /**
     * @Route("/del/{id}")
     * @Method({"DELETE", "POST"})
     */
    public function delAction(Request $request, Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return new JsonResponse([
            'message' => 'contact deleted'
        ]);
    }

    /**
     * @Route("/update/{id}")
     * @Method({"PUT", "POST"})
     */
    public function updateAction(Request $request, Contact $contact)
    {
        $contactData = $request->request->get("contact");
        
        $contact->setFirstName($contactData['firstname']);
        $contact->setLastName($contactData['lastname']);
        $contact->setPhone($contactData['phone']);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
        
        $exposeService = $this->get('expose');
        return new JsonResponse($exposeService->expose($contact));
    }

    /**
     * @Route("/show/{id}")
     * @Method({"GET", "POST"})
     */
    public function showAction(Contact $contact)
    {
        $exposeService = $this->get('expose');
        return new JsonResponse($exposeService->expose($contact));
    }

    /**
     * @Route("/")
     * @Method({"GET", "POST"})
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $contacts = $em->getRepository('RBContactBundle:Contact')->findAll();
        
        $exposeService = $this->get('expose');
        return new JsonResponse($exposeService->expose($contacts));
    }
}
