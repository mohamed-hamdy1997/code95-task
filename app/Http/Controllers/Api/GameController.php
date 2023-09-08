<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateTurnsRequest;

class GameController extends Controller
{
    public function generateTurns(GenerateTurnsRequest $request)
    {
        $numberOfPlayers = $request->input('players_num', 3);
        $numberOfTurns = $request->input('turns_num', 3);
        $startingPlayer = $request->input('starting_player', 'A');

        $players = range('A', chr(ord('A') + $numberOfPlayers - 1));

        $turns = [];

        for ($i = 0; $i < $numberOfTurns; $i++) {
            $turn = [];
            $playerIndex = array_search($startingPlayer, $players);

            for ($j = 0; $j < $numberOfPlayers; $j++) {
                $turn[] = $players[$playerIndex];

                $playerIndex++;
                if ($playerIndex >= $numberOfPlayers) {
                    $playerIndex = 0;
                }
            }

            $turns[] = $turn;

            $startingPlayerIndex = array_search($startingPlayer, $players);

            $players = array_merge(
                array_slice($players, $startingPlayerIndex),
                array_slice($players, 0, $startingPlayerIndex)
            );

            $startingPlayer = $players[1] ?? $players[0];
        }

        return response()->json($turns);
    }
}
