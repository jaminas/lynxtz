<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Category;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/api/categories", name="api_")
 */
class CategoryController extends FOSRestController
{
    /**
     * @Rest\Get
     * @return Response
     */
    public function tupple()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findall();
        return $this->handleView($this->view($categories));
    }
    
    /**
     * @Rest\Get("/{id}")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the Category",
     *     @SWG\Schema(ref=@Model(type=Category::class))
     * )
     * @return Response
     */
    public function get($id)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneBy(['id' => $id ]);
        if (!empty($category))
        {
            return $this->handleView(
                $this->view($category)
            );
        }
        else
        {
            return $this->handleView(
                $this->view(['status' => 'Category ID:'.$id.' wasn\'t found'], 
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
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->handleView(
                $this->view(['status' => 'ok'], 
                Response::HTTP_CREATED
            ));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Rest\Delete("/{id}")
     * @return Response
     */
    public function delete($id)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneBy(['id' => $id ]);
        if (!empty($category))
        {
            $category->setStatus(Category::STATUS_DELETED);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            
            return $this->handleView(
                $this->view(['status' => 'ok'], 
                Response::HTTP_OK
            ));
        }
        else
        {
            return $this->handleView(
                $this->view(['status' => 'Category ID:'.$id.' wasn\'t found'], 
                Response::HTTP_NOT_FOUND
            ));
        }
    }
}