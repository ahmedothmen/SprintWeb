<?php

namespace ProprieteBundle\Controller;

use ProprieteBundle\Entity\Imagepropriete;
use ProprieteBundle\Form\ImageproprieteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends Controller
{
    public function versAjouterImageAction(Request $request){

        $id=$request->get('id');
        $imageprop=new Imagepropriete();
        $form =$this->createForm('ProprieteBundle\Form\ImageproprieteType',$imageprop);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $file = $imageprop->getUrl();

            // Generate a unique name for the file before saving it

            $filename = $file->getClientOriginalName();


            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('image_directory'), $filename
            );
            $imageprop->setUrl($filename);
            $imageprop->setIdP($id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($imageprop);
            $em->flush();
            return $this->redirectToRoute('propriete_showAll');
        }

        return $this->render('ProprieteBundle:Image:versAjouterImage.html.twig', array(

            'form' => $form->createView(),
        ));
    }
}
