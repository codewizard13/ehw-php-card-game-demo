<?php
require_once('player.php');
include_once('utils/viewutilities_01.php');

class GameController
{
    private $player1;
    private $player2;
    private $handWinner = '';
    private $player1CurrScore = 0;
    private $player2CurrScore = 0;
    private $startGame = FALSE;
    private $startingDeck = array();        
    private $currentDeck = array();
    
    private static $instance; // for singleton
    
    private function __construct()
    {      
    }
    
    // singleton pattern
    static function getInstance()
    {
        if(!self::$instance)
        {
           self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function instantiatePlayers() {
        $this->player1 = new Player;
        $this->player2 = new Player;
    }
    
    public function getPlayer1() {
        return $this->player1;
    }
    
    public function getPlayer2() {
        return $this->player2;
    }    
    
    public function startNewGame() {
        // reset all values
        $this->instantiatePlayers();
        $this->startNewDeck();
        $this->shuffleDeck();
        $this->dealCards();
        $this->playGame();
        
    }

    private function dealCards() {
        // deal 26 cards to each player, in alternating fashion
        while (is_array($this->currentDeck) && count($this->currentDeck) > 0) {
            $this->player1->getMyCards($this->dealNextCard());
            $this->player2->getMyCards($this->dealNextCard()); 
        }
    }

    private function startNewDeck() {
        $d = array('A','A','A','A',
                    'K','K','K','K',
                    'Q','Q','Q','Q',
                    'J','J','J','J',
                    'T','T','T','T',
                    9,9,9,9,
                    8,8,8,8,
                    7,7,7,7,
                    6,6,6,6,
                    5,5,5,5,
                    4,4,4,4,
                    3,3,3,3,
                    2,2,2,2);
        $this->startingDeck = $d;
        $this->currentDeck = $d;
    }
    
    private function shuffleDeck() {
        // randomize card array
        shuffle($this->currentDeck);
        //return $this->currentDeck;
    }
    
    private function dealNextCard() {
        if ($this->currentDeck && is_array($this->currentDeck)) {            
            return array_shift($this->currentDeck);
        } else {
            return "NO DECK VALUES<br />";
        }
        
    }

    private function playGame() {
        echo "I'm in ".__FUNCTION__."<br />";
        
        $player1 = $this->player1;
        $player2 = $this->player2;
        
        //echo "<hr style='background:blue;color:blue;border:solid blue 6px;margin-bottom:20px;' />";
        ViewUtilities::debug($player1,'$player1',4);
        ViewUtilities::debug($player2,'$player2',4);
        ViewUtilities::debug($this,'$this',4);
        //echo "<hr style='background:blue;color:blue;border:solid blue 6px;margin-bottom:20px;' />";
        
        if ($player1 && is_object($player1) && $player2 && is_object($player2)) {
            echo "WE'RE IN 'If we have both players and they are objects ...<br />";
            $player1Cards = $this->player1->getMyCards();
            ViewUtilities::debug($player1Cards,"\$player1Cards",3);

            //$player1CardCount = count($this->player1->getMyCards());
            //$player2CardCount = count($this->player2->getMyCards());
            //
            //echo "Player 1 started with $player1CardCount cards.<br />";
            //echo "Player 2 started with $player2CardCount cards.<br />";

            while (count($this->player1->getMyCards()) > 0 && count($this->player2->getMyCards()) > 0) {
                
                echo "Player 1 has " . count($this->player1->getMyCards()) . " cards.</br>";
                echo "Player 2 has " . count($this->player2->getMyCards()) . " cards.</br>";
                
                $this->player1CardPlayed = $player1->playCard();
                echo "Player 1 Card Played = ".$this->player1CardPlayed."<br />";
                
                $this->player2CardPlayed = $player2->playCard();
                echo "Player 2 Card Played = ".$this->player2CardPlayed."<br />";
                echo "<script>alert('Player 1 Card: ".$this->player1CardPlayed."\nPlayer 2 Card: ".$this->player2CardPlayed."')</script>";
                //return;
                //echo "<hr style='background:blue;color:blue;border:solid blue 6px;margin-bottom:20px;' />";
                echo "Player 1 now has ". count($this->player1->getMyCards()) ." cards.<br />";
                echo "Player 2 now has ". count($this->player1->getMyCards()) ." cards.<br />";
                ViewUtilities::debug($this,'$$this',1);
                echo "<hr style='background:blue;color:blue;border:solid blue 6px;margin-bottom:20px;' />";
                
                //exit;
                
                
            }
            
        }
                
    }
    
    
















} // end class
?>