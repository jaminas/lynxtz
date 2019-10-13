<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Article;
use App\Entity\Search;
use App\Form\ArticleType;
use App\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/api/articles", name="api_")
 */
class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get
     * @return Response
     */
    public function tupple(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        
        $articles = $repository->findall();
        
        return $this->handleView(
            $this->view($articles)
        );
    }
    
    /**
     * @Rest\Post("/search")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the Article",
     *     @SWG\Schema(ref=@Model(type=Article::class))
     * )
     * @return Response
     */
    public function search(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            print_r($search);
            die;
            
            
            $articles = $repository->findBySearch($search);
            return $this->handleView(
                $this->view($articles)
            );
        }
        
        return $this->handleView(
            $this->view($form->getErrors())
        );
    }
    
    /**
     * @Rest\Get("/{id}")
     * @return Response
     */
    public function get($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findOneBy(['id' => $id ]);
        if (!empty($article))
        {
            return $this->handleView(
                $this->view($article)
            );
        }
        else
        {
            return $this->handleView(
                $this->view(['status' => 'Article ID:'.$id.' wasn\'t found'], 
                Response::HTTP_NOT_FOUND
            ));
        }
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Rest\Post
     * @return Response
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            
            return $this->handleView(
                $this->view(['status' => 'ok'], 
                Response::HTTP_CREATED
            ));
        }
        return $this->handleView(
            $this->view($form->getErrors())
        );
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Rest\Delete("/{id}")
     * @return Response
     */
    public function delete($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findOneBy(['id' => $id ]);
        if (!empty($article))
        {
            $article->setStatus(Article::STATUS_DELETED);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            
            return $this->handleView(
                $this->view(['status' => 'ok'], 
                Response::HTTP_OK
            ));
        }
        else
        {
            return $this->handleView(
                $this->view(['status' => 'Article ID:'.$id.' wasn\'t found'], 
                Response::HTTP_NOT_FOUND
            ));
        }
    }

}