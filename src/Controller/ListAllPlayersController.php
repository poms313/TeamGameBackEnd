<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAllPlayersController extends AbstractController
{
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }


    #[Route('/list/all/players', name: 'list_all_players')]
    public function getAllPlayers(): Response
    {
        $dbPlayersList = $this->playerRepository->findAll();
        $playerListForConverting = array();

        foreach($dbPlayersList as $player){
            $playerListForConverting[] = $player->buildArray();
          }
          return new JsonResponse(
            array(
              "players" => $playerListForConverting
            )
          );
    }
}