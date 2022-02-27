<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PlayerRepository;
use App\Entity\Player;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameController extends AbstractController
{
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @Route("/game/create", methods={"GET"})
     */
    public function createGame(): JsonResponse
    {
       $allPlayers = $this->playerRepository->findAll();
        if (count($allPlayers) >= 10) {

            $player = new Player();
            $data = array();
    
            for ($i = 1; $i <= 3; $i++) {
                $player = $this->playerRepository->findOneBy(['id' => rand(1, 10)]);
                $player->setTeam(1);
                array_push($data, $player->buildArray());
            }
    
            for ($g = 1; $g <= 3; $g++) {
                $player = $this->playerRepository->findOneBy(['id' => rand(1, 10)]);
                $player->setTeam(2);
                array_push($data, $player->buildArray());
            }
        }
        

        return $this->json(
            $data
        );
    }

    /**
     * @Route("/result/{jsonData}", methods={"GET", "POST"})
     */
    public function gameResult($jsonData): JsonResponse
    {
        if (empty($jsonData)) {
            $result = 'error';
        } else {
            $teamOne = 0;
            $teamTwo = 0;

            $formData =  json_decode($jsonData, true);
            $players = $formData['players'];
            $testName = $formData['testName'];

            foreach ($players as $player) {
                if ($player['team'] == 1) {
                    $teamOne += $player[$testName];
                }
                if ($player['team'] == 2) {
                    $teamTwo += $player[$testName];
                }
            }

            if ($teamOne < $teamTwo) {
                $result = array(
                    'winner'=> 'teamTwo',
                    'teamOneScore'=> $teamOne,
                    'teamTwoScore'=> $teamTwo
                );
            }

            if ($teamOne > $teamTwo) {
                $result = array(
                    'winner'=> 'teamOne',
                    'teamOneScore'=> $teamOne,
                    'teamTwoScore'=> $teamTwo
                );
            }

            if ($teamOne == $teamTwo) {
                $result = array(
                    'winner'=> 'null',
                    'teamOneScore'=> $teamOne,
                    'teamTwoScore'=> $teamTwo
                );
            }
        }
        return $this->json(
            $result
        );
    }
}
