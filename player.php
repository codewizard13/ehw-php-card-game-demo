<?php

class Player {
	
	private $message = "Hi, I'm a player!";
	private $displayCardFaceUP = TRUE;

	private $myCards = array();
	private $myCardValue = '';
	
	public function __construct() {
		
	}
	
	public function playCard() {		
		$this->myCardValue = array_shift($this->myCards);
		return $this->myCardValue;
	}
	
	public function getIsCardFacingUp() {
		return $this->displayCardFaceUP;
	}
	
	public function getMyCards($card=NULL) {
		if (isset($card)) {
			$this->addToCards($card);
		}
		return $this->myCards;
	}
	
	private function addToCards($card) {
		$this->myCards[] = $card;
	}
	
	
} // end class

?>