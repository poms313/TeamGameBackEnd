<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/get/player/{id}', name: 'get_player', methods: ['GET'])]
    public function getOnePlayer($id): JsonResponse
    {

        $bdPlayer = $this->playerRepository->findOneBy(['id' => $id]);
        if (is_null($bdPlayer)) {
            $player = 'error';
        } else {
            $player = $bdPlayer->buildArray();
        }

        return new JsonResponse(
            $player
        );
    }

    #[Route('/modify/player/{formData}', name: 'modify_player', methods: ['POST'])]
    public function modifyPlayer($formData): JsonResponse
    {
        if (empty($formData)) {
            $player = 'error';
        } else {
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
            $player = $playerToModify->buildArray();;
        }

        return new JsonResponse(
            $player
        );
    }
}
