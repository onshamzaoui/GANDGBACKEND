<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="GET_ALL_CATEGORIES",methods={"GET"})
     */
    public function GetAllCategory(CategoryRepository $categoryRepository): Response
    {
        return $this->json($categoryRepository->findAll(),200,[],['groups'=>'category']);
    }


/**
 * @Route("/api/category/{id}", name="GET_ONE_CATEGORY_BY_ID", methods={"GET"})
 */
public function GetOneCategoryById($id, CategoryRepository $categoryRepository)
{

    if ($categoryRepository->find($id) == null) {
        $json = ['message' => 'id not found']; 

        return $this->json($json, 400, []);
    }

    
    return $this->json($categoryRepository->find($id), 200, [], ['groups' => 'category']);
}
}
