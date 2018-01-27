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
    const VERSION = "Default PHP folding player";

    public function betRequest($game_state)
    {
        try {
            $filePairs = file_get_contents('fold.txt');

            $pairsToFold = explode('|', $filePairs);

            $round = $game_state['round'];

            $self = null;

            foreach ($game_state['players'] as $player) {
                if (array_key_exists('hole_cards', $player)) {
                    $self = $player;
                }
            }

            $card1 = new Card($self['hole_cards']['0']['rank'],$self['hole_cards']['0']['suit']);
            $card2 = new Card($self['hole_cards']['1']['rank'],$self['hole_cards']['1']['suit']);

            foreach ($pairsToFold as $item) {
                $tmp = explode('-',$item);
                if (($card1->getRank() == $tmp[0] && $card2->getRank() == $tmp[1]) ||
                    ($card1->getRank() == $tmp[1] && $card2->getRank() == $tmp[0])) {
                    return 0;
                }
            }

            return 100000;  
        } catch (\Exception $e) {

            return 100000;
        }
    }

    public function showdown($game_state)
    {

    }
}
