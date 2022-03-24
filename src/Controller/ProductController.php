<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(): Response
    {
        return $this->json(['description' => 'bien','name' => 'jane.doe']);
    }

    /**
     * @Route("/", name="list_product")
     */
    public function Affichage(): Response
    {
        $data = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->json([
            'name' => $data 
        ]);
    }

    /**
     * @Route("/product/create", name="product_new")
     */
    public function CreateProduct(Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $content = $request->getContent();
        $param = json_decode($content, true);
        $product = new Product();
        $product->setName($param['Name']);
        $product->setDescription($param['Description']);
        $product->setPrice($param['Price']);
        $em->persist($product);
        $em->flush();
        return new JsonResponse(
            [
                "massage" => "created successfly"
            ]
            );
    }

    /**
     * @return Response
     *
     * @Route("/modification/{id}", name="modification_product")
     */
    public function modification(Request $request, Product $product){
        $content = $request->getContent();
        $param = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        $product->setName($param['Name']);
        $product->setDescription($param['Description']);
        $product->setPrice($param['Price']);
        $em->flush();
        return new JsonResponse(
            [
                "massage" => "update successfly"
            ]
            );
    }

    /**
     * @Route("/produit/supprimer/{id}", name="suppression_produit")
     */
    public function SuprimerCategory(Request $request, Product $product): Response{
        $em = $this->getDoctrine()->getManager();
        $content = $request->getContent();
        $param = json_decode($content, true);
        $em->remove($product);
        $em->flush();
        return new JsonResponse(
            [
                "massage" => "supprimer "
            ]
            );
    }
}
