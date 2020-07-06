<?php

namespace App\Controller;
use App\Entity\Articles;
use App\entity\Commentaires;
use App\Form\CommentaireFormType;
use App\Form\AjoutArticleFormType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ArticlesController
 * @package App\Controller
 * @Route("/actualites", name="actualites_")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="articles")
     */
    public function index()
    {
        //On appelle la liste de tous les articles
        $articles = $this->getDoctrine()->getRepository(Articles::class)->findAll();
        
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/article/new", name="ajout_Article")
     */
    public function ajoutArticle(Request $request)
    {
        $article = new Articles();

        $form = $this->createForm(AjoutArticleFormType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setUsers($this->getUser());
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($article);
            $doctrine->flush();

            $this->addFlash('message', 'Votre article est publié');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('articles/ajout.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/article/{slug}", name="article")
     */
    public function article($slug, Request $request)
    {
        //On appelle la liste de tous les articles
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy([
            'slug' => $slug
        ]);
        
        if(!$article){
            throw $this->createNotFoundException("L'article recherché n'existe pas");
        }
        
        //On instancie l'entité Commentaires
        $commentaire = new Commentaires();

        //creation l'objet form
        $form = $this->createForm(CommentaireFormType::class, $commentaire);

        //On récupère les données saisies
        $form->handleRequest($request);

        //On vérifie si le form a été envoyé et les données sont valide 
        if($form->isSubmitted() && $form->isValid()){
            //Ici le form a été envoyé et il est valide 
            $commentaire->setArticles(($article));
            $commentaire->setCreatedAt(new \DateTime('now'));

            //On instancie Doctrine
            $doctrine = $this->getDoctrine()->getManager();

            //On hydrate
            $doctrine->persist($commentaire);

            //et on ecrit dans la db
            $doctrine->flush();
        }

        return $this->render('articles/article.html.twig', [
            'article' => $article,
            'formComment' => $form->createView()
        ]);
    }
}
