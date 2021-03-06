<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\OwnerRepository;
use App\Repository\SellerRepository;
use App\Repository\ProductRepository;
use Lcobucci\JWT\Validation\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/products", name="GET_ALL_PRODUCTS", methods={"GET"})
     */
    public function GetAllProducts(ProductRepository $productRepository)
    {

        return $this->json($productRepository->findAll(), 200, [], ['groups' => 'product']);
    }

    /**
     * @Route("/api/product/{id}", name="GET_ONE_PRODUCT_BY_ID", methods={"GET"})
     */
    public function GetOneProductById($id, ProductRepository $productRepository)
    {

        if ($productRepository->find($id) == null) {
            $json = ['message' => 'id not found']; 

            return $this->json($json, 400, []);
        }

        
        return $this->json($productRepository->find($id), 200, [], ['groups' => 'product']);
    }

    /**
     * @Route("/api/products/owner/{id}", name="GET_ALL_OWNER_PRODUCT_BY_ID", methods={"GET"})
     */
    public function GetByOwnerId($id, ProductRepository $productRepository)
    {

        if ($productRepository->findBy(['Owner' => $id]) == null) {
            $json = ['message' => 'id not found'];

            return $this->json($json, 400, []);
        }
        return $this->json($productRepository->findBy(['Owner' => $id]), 200, [], ['groups' => 'product']);
    }
        /**
     * @Route("/api/products/category/{id}", name="GET_ALL_CATEGORIES_PRODUCT_BY_ID", methods={"GET"})
     */
    public function GetByCategoryId($id, ProductRepository $productRepository)
    {

        if ($productRepository->findBy(['Category' => $id]) == null) {
            $json = ['message' => 'id not found'];

            return $this->json($json, 400, []);
        }
        return $this->json($productRepository->findBy(['Category' => $id]), 200, [], ['groups' => 'product']);
    }

    /**
     * @Route("/api/product/{id}", name="DELETE_PRODUCT", methods={"DELETE"})
     */
    public function DeleteProduct($id, ProductRepository $productRepository, EntityManagerInterface $entityManagerInterface)
    {
        if ($productRepository->find($id) == null) {
            $json = ['message' => 'id not found'];

            return $this->json($json, 400, []);
        }

        $product = $productRepository->findOneBy(['id' => $id]);

        $entityManagerInterface->remove($product);
        $entityManagerInterface->flush();

        $json = [
            'Deleted Product' => $product,
            'message' => 'product deleted successfully',
        ];

        return $this->json($json, 202, [], ['groups' => 'product']);
    }


    /**
     * @Route("/api/product", name="ADD_NEW_PRODUCT", methods={"POST"})
     */
    public function AddNewProduct(Request $request, OwnerRepository $ownerRepository , CategoryRepository $categoryRepository , SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManagerInterface)
    {
        $jsonResponse = $request->getContent();

        $product = $serializer->deserialize($jsonResponse , Product::class , 'json');

        $entityManagerInterface->persist($product);
        $entityManagerInterface->flush();



        // try {



        //     $product = $serializer->deserialize($jsonResponse, Product::class, 'json');
            

        //     $product->setOwner($ownerRepository->find($product->getOwner()->getId()));

            
        //     $product->setCategory($categoryRepository->find($product->getCategory()->getId()));

            


        //     // $errors = $validator->validate($product);

        //     // if (count($errors) > 0) {
        //     //     return $this->json($errors, 400);
        //     // }


        //     $entityManagerInterface->persist($product);

        //     $entityManagerInterface->flush();


        //     return $this->json($product, 201, [] , ['groups' => 'product'] );


        // } catch (NotEncodableValueException $e) {
        //     return $this->json([
        //         'status' => $e->getCode(),
        //         'message' => $e->getMessage()
        //     ], 400);
        // } catch (NotNullConstraintViolationException $e) {
        //     return $this->json([
        //         'status' => $e->getErrorCode(),
        //         'message' => $e->getMessage(),
        //     ], 400);
        // }
    }

    /**
     * @Route("/api/product/{id}", name="UPDATE_PRODUCT", methods={"PUT"})
     */
    public function UpdateProduct($id , ProductRepository $productRepository , Request $request , EntityManagerInterface $entityManagerInterface , SerializerInterface $serializer ){
        
        $jsonResponse = $request->getContent();

        $product = $productRepository->find($id);

        
        $updatedProduct = json_decode($jsonResponse , true);


        
        empty($updatedProduct['ProductName']) ? true : $product->setProductName($updatedProduct['ProductName']);
        empty($updatedProduct['ProductImage']) ? true : $product->setProductImage($updatedProduct['ProductImage']);
        empty($updatedProduct['Description']) ? true : $product->setDescription($updatedProduct['Description']);
        empty($updatedProduct['initialPrice']) ? true : $product->setinitialPrice($updatedProduct['initialPrice']);
        empty($updatedProduct['SellingPrice']) ? true : $product->setSellingPrice($updatedProduct['SellingPrice']);
        empty($updatedProduct['State']) ? true : $product->setState($updatedProduct['State']);
        




        $entityManagerInterface->persist($product);
        $entityManagerInterface->flush();

        
        return $this->json($product, 204, [] , ['groups' => 'product'] );

    }


}
