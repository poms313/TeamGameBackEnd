<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class PlayerController extends AbstractController
{
    public function __construct(PlayerRepository $playerRepository, ManagerRegistry $doctrine)
    {
        $this->playerRepository = $playerRepository;
        $this->doctrine = $doctrine;
    }


    /**
     * @Route("/get/player/{id}", methods={"GET"})
     */
    public function getOnePlayer($id): JsonResponse
    {
        $bdPlayer = $this->playerRepository->findOneBy(['id' => $id]);
        if (is_null($bdPlayer)) {
            $data = 'error';
        } else {
            $data = $bdPlayer->buildArray();
        }

        return new JsonResponse(
            $data
        );
    }

    /**
     * @Route("/modify/{player}", methods={"GET", "POST"})
     */
    public function modifyPlayer($player): JsonResponse
    {
        if (empty($player)) {
            $data = null;
        } else {
            $formData =  json_decode($player, true);

            $playerToModify = new Player();
            $playerToModify = $this->playerRepository->findOneBy(['id' => $formData['id']]);
            $playerToModify->setName($formData['name']);
            $playerToModify->setStrength($formData['strength']);
            $playerToModify->setMemory($formData['memory']);
            $playerToModify->setIntelligence($formData['intelligence']);
            $playerToModify->setLogic($formData['logic']);
            $playerToModify->setResistance($formData['resistance']);
            $playerToModify->setFighting($formData['fighting']);
            $entityManager = $this->doctrine->getManager();
            $entityManager->flush();
            $data = $playerToModify->buildArray();
        }

        return new JsonResponse(
            $data
        );
    }
}
