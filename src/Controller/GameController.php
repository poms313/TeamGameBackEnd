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

    #[Route('/game/create', name: 'game_create', methods: ['GET'])]
    public function createGame(): JsonResponse
    {
        $player = new Player();

        $teamOne = array();
        for ($i = 1; $i <= 3; $i++) {
            $player = $this->playerRepository->findOneBy(['id' => rand(1, 10)]);
            $player->setTeam(1);
            array_push($teamOne, $player->buildArray());
        }

        $teamTwo = array();
        for ($g = 1; $g <= 3; $g++) {
            $player = $this->playerRepository->findOneBy(['id' => rand(1, 10)]);
            $player->setTeam(2);
            array_push($teamTwo, $player->buildArray());
        }

        return $this->json([
            'teamOne' => $teamOne,
            'teamTwo' => $teamTwo,
        ]);
    }

    #[Route('/game/result/{formData}', name: 'game_result', methods: ['POST'])]
    public function index($formData): JsonResponse
    {
        if (empty($formData)) {
            $result = 'error';
        } else {
            $teamOne = 0;
            $teamTwo = 0;
            $critary = $formData['critary'];

            foreach ($formData as $player) {
                if ($player['team'] = '1') {
                    $teamOne += $player[$critary];
                } else {
                    $teamTwo += $player[$critary];
                }
            }

            if ($teamOne < $teamTwo) {
                $result = 'teamTwo';
            }

            if ($teamOne > $teamTwo) {
                $result = 'teamOne';
            }

            if ($teamOne == $teamTwo) {
                $result = 'null';
            }
        }
        return new JsonResponse(
            $result
        );
    }
}
