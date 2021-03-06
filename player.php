<?php

class Card
{
    const SUIT_SPADES = 'spades';
    const SUIT_HEARTS = "hearts";
    const SUIT_CLUBS = "clubs";
    const SUIT_DIAMONDS = "diamonds";

    public $rank;
    public $suit;

    public function __construct($rank, $suit)
    {
//        if (intval($rank) <= 10) {
//            $this->rank = intval($rank);
//        } else if ($rank = 'J') {
//            $this->rank = 11;
//        } else if ($rank = 'Q') {
//            $this->rank = 12;
//        } else if ($rank = 'K') {
//            $this->rank = 13;
//        } else if ($rank = 'A') {
//            $this->rank = 14;
//        }
        $this->rank = $rank;
        $this->suit = $suit;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * @param mixed $suit
     */
    public function setSuit($suit)
    {
        $this->suit = $suit;
    }
}

class Player
{
    const VERSION = "Hupsz";

    public function betRequest($game_state)
    {

        try {
            $filePairs = file_get_contents('fold.txt');
            $pairsToFold = explode('|', $filePairs);

            $fileHold = file_get_contents('hold.txt');
            $pairsToHold = explode('|', $fileHold);

            $round = $game_state['round'];

            $self = null;

            $active = 0;
            $out = 0;

            foreach ($game_state['players'] as $player) {
                if (array_key_exists('hole_cards', $player)) {
                    $self = $player;
                }

                if ($player['status'] == 'active') {
                    $active++;
                }

                if ($player['status'] == 'out') {
                    $out++;
                }
//                else {
//                    if ($player['status'] == 'active') {
//
//                    }
//                }
            }

            $card1 = new Card($self['hole_cards']['0']['rank'],$self['hole_cards']['0']['suit']);
            $card2 = new Card($self['hole_cards']['1']['rank'],$self['hole_cards']['1']['suit']);

//            foreach ($pairsToFold as $item) {
//                $tmp = explode('-',$item);
//                if (($card1->getRank() == $tmp[0] && $card2->getRank() == $tmp[1]) ||
//                    ($card1->getRank() == $tmp[1] && $card2->getRank() == $tmp[0])) {
//                    $this->log("FOLD BY HAND");
//                    return 0;
//                }
//            }

//            if ($out >= 2 || $self['stack'] < 500) {

//            if ($self['stack'] >= 2000) {
//                return 10000;
//            }


            if ($self['stack'] < 200) {
                return 10000;
            } else {
                return 0;
            }
            
            foreach ($pairsToHold as $item) {

                $tuple = explode('-', $item); // [A,9,O]

                $suited = $card1->getSuit() == $card2->getSuit() ? 'S' : 'O';

                if ((($card1->getRank() == $tuple[0] && $card2->getRank() == $tuple[1]) ||
                        ($card1->getRank() == $tuple[1] && $card2->getRank() == $tuple[0])) && $suited == $tuple[2]) {

                    if ($game_state['pot'] >= 3 * $game_state['small_blind']) {
                        return 10000;
                    } else {

                        if ($game_state['pot'] <= 3 * $game_state['small_blind']) {
                            $this->log("POT < 100");
                            return $game_state['minimum_raise'] + 2;
                        }

                        return 0;
                    }


                }
            }
//            }

            if ($game_state['pot'] <= 3 * $game_state['small_blind']) {
                $this->log("POT < 100");
                return $game_state['minimum_raise'] + 2;
            }

            $this->log("RETURN FOLD");

            return 0;

        } catch (\Exception $e) {
            $this->log("EXCEPTION: " . $e->getMessage());
            return 100000;
        }

//        $rnd = rand(0,100);
//        if ($rnd < 30) {
//            return 0;
//        } else {
//            return 10000;
//        }
    }

    public function showdown($game_state)
    {

    }

    public function log($message) {
        file_put_contents("php://stderr", '####THIS####  ' . $message);
    }
}
