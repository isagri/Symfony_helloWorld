<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 17/07/2018
 * Time: 16:27
 */

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ProductController
 * @package App\Controller
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * @Route("/add", name="product.add")
     */
    function addProduct(Request $request)
    {
        $product = new Product();
        $form = $this
            ->createFormBuilder($product)
            ->add("name", TextType::class)
            ->add("releaseOn", DateType::class, ["widget" => "single_text"])
            ->add("save", SubmitType::class, ["label" => "create Product"])
            ->getForm();

        // handleRequest récupère les data du formulaire -> va mettre à jour directement le produit
        // car on a passé le produit dans le createFormBuilder
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("product.all");
        }
        return $this->render("product/add.html.twig", ["form" => $form->createView(), "result" => $product]);
    }

    /**
     * @Route("/all", name="product.all")
     */
    function allProduct(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        return $this->render("product/all.html.twig", ["products" => $products]);
    }

    /**
     * @Route("/update/{product}", name="product.update")
     */
    function updateProduct(Request $request, Product $product)
    {
        //$em = $this->getDoctrine()->getManager();

        $form = $this
            ->createFormBuilder($product)
            ->add("name", TextType::class)
            ->add("releaseOn", DateType::class, ["widget" => "single_text"])
            ->add("save", SubmitType::class, ["label" => "save Product"])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("product.all");

        }
        return $this->render("product/add.html.twig", ["form" => $form->createView(), "result" => $product]);
    }


    /**
     * @Route("/delete/{product}", name="product.delete")
     */
    function deleteProduct(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("product.all");
    }

}
