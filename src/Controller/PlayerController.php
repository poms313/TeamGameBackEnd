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
     * @Route("/modify/player/{jsonData}", methods={"GET", "POST"})
     */
    public function modifyPlayer($jsonData): JsonResponse
    {
        if (empty($jsonData)) {
            $data = null;
        } else {
            $formData =  json_decode($jsonData, true);
            $playerToModify = new Player();
            $playerToModify = $this->playerRepository->findOneBy(['id' => $formData['id']]);
            $playerToModify = $this->convertDataToPlayer($playerToModify, $formData);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($playerToModify);
            $entityManager->flush();
            $data = $playerToModify->buildArray();
        }

        return new JsonResponse(
            $data
        );
    }

    /**
     * @Route("/delete/player/{id}", methods={"GET"})
     */
    public function deletePlayer($id): JsonResponse
    {
        $bdPlayer = $this->playerRepository->findOneBy(['id' => $id]);
        if (!empty($bdPlayer)) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($bdPlayer);
            $entityManager->flush();
            $data = true;
        } else {
            $data = false;
        }

        return new JsonResponse(
            $data
        );
    }

    /**
     * @Route("/add/player/{jsonData}", methods={"GET"})
     */
    public function addPlayer($jsonData): JsonResponse
    {
        if (!empty($jsonData)) {
            $formData =  json_decode($jsonData, true);
            $playerToAdd = new Player();
            //when the game starts, players are randomly selected by id. The function checks which identifiers are free between 0 and 10
           $idToAttribute = $this->checkUsedIdInDatabase();
           if (!is_null($idToAttribute)) {
            $playerToAdd->setId($idToAttribute);
           }
            $playerToAdd = $this->convertDataToPlayer($playerToAdd, $formData);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($playerToAdd);
            $entityManager->flush();
            $data = $playerToAdd;
        } else {
            $data = false;
        }

        return new JsonResponse(
            $data
        );
    }


    public function convertDataToPlayer($player, $formData)
    {
        $player->setName($formData['name']);
        $player->setStrength($formData['strength']);
        $player->setMemory($formData['memory']);
        $player->setIntelligence($formData['intelligence']);
        $player->setLogic($formData['logic']);
        $player->setResistance($formData['resistance']);
        $player->setFighting($formData['fighting']);
     
        return $player;
    }

    public function checkUsedIdInDatabase() {
        $numbers = array(1,2,3,4,5,6,7,8,9,10);
        foreach ($numbers as &$testedNumber) {
            $bdUsedId = $this->playerRepository->findOneBy(['id' => $testedNumber]);
            if (empty($bdUsedId)) {
                return $testedNumber;
            } else return null;
        }
    }
}
