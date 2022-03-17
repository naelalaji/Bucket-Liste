<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/wish", name="app_wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        $wishRepo = $this->getDoctrine()->getRepository(Wish::class);
        $wishes = $wishRepo->findBy(["isPublished"=>true],["dateCreated"=>"desc"]);
        return $this->render('wish/list.html.twig',compact("wishes"));
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id): Response
    {
        $wishRepo = $this->getDoctrine()->getRepository(Wish::class);
        $wish = $wishRepo->find($id);
        return $this->render('wish/detail.html.twig');
    }

     /**
     * @Route("/ajouter", name="ajouter")
     */
    public function Ajouterlist(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        if(!empty ($request->getMethod()=='POST')){
            $title =$request->request->get("title");
            $description =$request->request->get("description");
            $author =$request->request->get("author");
            $isPublished =$request->request->get("isPublished");
            $dateCreated =$request->request->get("dateCreated");

            $wish = new Wish();
            $wish->setTitle("$title")
                 ->setDescription("$description")   
                 ->setAuthor("$author")  
                 ->setIsPublished("$isPublished")   
                 ->setDateCreated(new \DateTime($dateCreated));   

            $em->persist($wish);
            $em->flush();
        }
        return $this->render('wish/ajouter.html.twig');
    }

}
