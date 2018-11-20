<?php
    class Test 
    {
        // muutujad e. omadused - properties
        // funktsioonid e. meetodid - methods
        private $secretNumber;
        public $publicNumber;
        
        // konstruktor - käivitatakse üks kord objekti loomisel

        public function __construct($givenNumber) {
            $this -> secretNumber = 4; // $this võtab välise skoobi ehk klassi Test muutuja
            $this -> publicNumber = $this -> secretNumber * $givenNumber;
            $this -> tellSecrets(); // saladused loetakse välja
        }

        public function __destruct() {
            echo "Lõpetame!";
        }

        private function tellSecrets() {
            echo "Klassi salajane arv on " . $this -> secretNumber . "\n";
        }

        public function tellThings() {
            echo "Saladustele (" . $this -> secretNumber . ") pääseb ligi vaid klass ise.";
        }

    } // class
?>