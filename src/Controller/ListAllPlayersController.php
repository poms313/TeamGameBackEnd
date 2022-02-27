<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class ListAllPlayersController extends AbstractController
{

  public function __construct(PlayerRepository $playerRepository, ManagerRegistry $doctrine)
  {
    $this->playerRepository = $playerRepository;
    $this->doctrine = $doctrine;
  }

  /**
   * @Route("/list/all/players", methods={"GET"})
   */
  public function getAllPlayers(): JsonResponse
  {
    $dbPlayersList = $this->playerRepository->findAll();
    $playerListForConverting = array();

    if (empty($dbPlayersList)) {
      $dbPlayersList = $this->generatePlayers();
    }

    foreach ($dbPlayersList as $player) {
      $playerListForConverting[] = $player->buildArray();
    }
    return new JsonResponse(
      $playerListForConverting
    );
  }

  public function generatePlayers()
  {
    $playersName = array('Paul', 'Ingrid', 'Eric', 'Marion', 'Sophie', 'Christelle', 'Nadia', 'Benoit', 'Claude', 'Claudia');

    foreach ($playersName as $item) {
      $newPlayer = new Player();
      $newPlayer->setName($item);
      $newPlayer->setStrength(rand(1, 100));
      $newPlayer->setMemory(rand(1, 100));
      $newPlayer->setIntelligence(rand(1, 100));
      $newPlayer->setLogic(rand(1, 100));
      $newPlayer->setResistance(rand(1, 100));
      $newPlayer->setFighting(rand(1, 100));
      $entityManager = $this->doctrine->getManager();
      $entityManager->flush();
    }
  }
}
