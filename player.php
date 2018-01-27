<?php

class Player
{
    const VERSION = "Default PHP folding player";

    public function betRequest($game_state)
    {
//        $game_state

        $string = file_get_contents("player-api.json");
        $json_a = json_decode($string, true);


        return 10000;
    }

    public function showdown($game_state)
    {

    }
}
