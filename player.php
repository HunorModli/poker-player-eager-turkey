<?php

class Player
{
    const VERSION = "Default PHP folding player";

    public function betRequest($game_state)
    {
        $filePairs = file_get_contents('fold.txt');

        $pairsToFold = explode('|', $filePairs);

        $round = $game_state['round'];

        $self = null;

        foreach ($game_state['players'] as $player) {
            if (array_key_exists('hole_cards', $player)) {
                $self = $player;
            }
        }

        $card1 = new Card($self['hole_cards']['0']['rank'],$self['hole_cards']['0']['suite']);
        $card2 = new Card($self['hole_cards']['1']['rank'],$self['hole_cards']['1']['suite']);

        foreach ($pairsToFold as $item) {
            $tmp = explode('-',$item);
            if (($card1->getRank() == $tmp[0] && $card2->getRank() == $tmp[1]) ||
                ($card1->getRank() == $tmp[1] && $card2->getRank() == $tmp[0])) {
                return 0;
            }
        }

        return 100000;
    }

    public function showdown($game_state)
    {

    }
}
