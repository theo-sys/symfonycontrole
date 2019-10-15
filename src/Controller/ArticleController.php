<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_liste")
     */
    public function listeArticles(ArticleRepository $repo)
    {
        //chercher l'ensemble des articles et on le stock
        $articles=$repo->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles //on va le donner dans twig
        ]);
    }
    /**
         * permet de créer une annonce
         * 
         * @Route("/articles/new", name="article_create")
         *
         * @return Response
         */
        public function create(Request $request, ObjectManager $manager){
            $article=new Article();

            $form =$this->createForm(ArticleType::class, $article);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                foreach($article->getImages() as $image){
                    $image->setArticle($article);
                    $manager->persist($image);
                }

                $manager->persist($article);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "l'annonce <strong>{$article->getTitle()}</strong> a bien été ajoutée !"
                );

                return $this->redirectToRoute('article_show', [
                    'slug' => $article->getSlug()
                ]);
            } 

            return $this->render('article/new.html.twig', [
                'form' =>$form->createView()
            ]);
        }
    /**
     * @Route("/article/{id}", name="article_affiche")
     */
    public function afficheArticle(Article $article)
    {
        return $this->render('article/afficheArticle.html.twig', [
            'article' => $article
        ]);
    }

    
}
