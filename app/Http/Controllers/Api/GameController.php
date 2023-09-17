<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateTurnsRequest;

class GameController extends Controller
{
    public function generateTurns(GenerateTurnsRequest $request)
    {
        $numPlayers = $request->input('players_num', 3);
        $numTurns = $request->input('turns_num', 3);
        $startPlayer = $request->input('starting_player', 'A');

        $players = range('A', chr(ord('A') + $numPlayers - 1));

        // Find the index of the start player in the players array
        $startIndex = array_search($startPlayer, $players);

        // Initialize the resulting turns array
        $turns = [];
        $nextReverse = ($numTurns / ($numTurns % $numPlayers));
        // Generate the turns based on the specified number of turns
        for ($i = 0; $i < $numTurns; $i++) {
            $turn = [];

            // Add players to the turn in the specified order
            for ($j = 0; $j < $numPlayers; $j++) {
                $playerIndex = ($startIndex + $j) % $numPlayers;
                $turn[] = $players[$playerIndex];
            }

            // Update the start index for the next turn
            if ($i < $nextReverse) {
                $startIndex = ($startIndex + 1) % $numPlayers;
            } else {
                $startIndex = $startIndex - 1;
                if ($startIndex < 0) {
                    $nextReverse = ($numTurns / ($numTurns % $numPlayers));

                    $players = array_reverse($players);
                    $startIndex = array_search($startPlayer, $players);
                }
            }

            if ($i == $nextReverse) {
                $startIndex = $numPlayers - 1;
            }

            // Add the turn to the turns array
            $turns[] = $turn;
        }

        return response()->json($turns);
    }
}
