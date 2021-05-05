<?php

namespace App\Controller;

use App\Entity\Issue;
use Doctrine\ORM\EntityManager;
use App\Repository\IssueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IssueController extends AbstractController
{
    /**
     * @Route("/api/Issues", name="api_GetAll_Issues", methods={"GET"})
     */
    public function getAllIssues(IssueRepository $issueRepository)
    {

        return $this->json($issueRepository->findAll(), 200, [], ['groups' => 'issue']);
    }
    /**
     * @Route("/api/Issue/{id}", name="GET_ALL_BY_ID", methods={"GET"})
     */

    public function GetOwnerbyId($id, IssueRepository $issueRepository)
    {
        if ($issueRepository->find($id) == null) {
            $json = ['message' => 'id not found'];

            return $this->json($json, 400, []);
        }
        return $this->json($issueRepository->find($id), 200, [], ['groups' => 'issue']);
    }
    /**
     * @Route("/api/Issue", name="ADD_NEW_ISSUE", methods={"POST"})
     */
    public function AddNewIssue(Request $request,  SerializerInterface $serializer, EntityManagerInterface $entityManagerInterface)
    {
        $jsonResponse = $request->getContent();

        $issue = $serializer->deserialize($jsonResponse, Issue::class, 'json');




        $entityManagerInterface->persist($issue);
        $entityManagerInterface->flush();

        return $this->json($issue, 201, [], ['groups' => 'issue']);
    }
    /**
     * @Route("/api/Issue/{id}", name="UPDATE_ISSUE", methods={"PUT"})
     */
    public function Update($id, IssueRepository $issueRepository, Request $request, EntityManagerInterface $entityManagerInterface, SerializerInterface $serializer)
    {

        $jsonResponse = $request->getContent();

        $issue = $issueRepository->find($id);


        $updatedIssue = json_decode($jsonResponse, true);

        empty($updatedIssue['issue']) ? true : $issue->setIssue($updatedIssue['issue']);



        $entityManagerInterface->persist($issue);
        $entityManagerInterface->flush();


        return $this->json($issue, 204, [], ['groups' => 'issue']);
    }
      /**
     * @Route("/api/Issue/{id}", name="DELETE_ISSUE", methods={"DELETE"})
     */
    public function DELETE($id, IssueRepository $issueRepository, EntityManagerInterface $entityManagerInterface)
    {
        if ($issueRepository->find($id) == null) {
            $json = ['message' => 'id not found'];

            return $this->json($json, 400, []);
        }

        $issue = $issueRepository->findOneBy(['id' => $id]);

        $entityManagerInterface->remove($issue);
        $entityManagerInterface->flush();

        $json = [
            'Deleted Issue' => $issue,
            'message' => 'issue deleted successfully',
        ];

        return $this->json($json, 202, [], ['groups' => 'issue']);
    }
    // GET /api/issue/{id}
    // POST /api/issue
    // PUT(UPDATE) /api/issue/{id}
    // DELETE /api/issue/{id}
}
