<?php


/*
deal 2 cards to each player. no 2 cards can be the same - make an array of the cards? Remove each one as it deals
add up scores of each card some logic to apply values to each card or add the cards value to the array
decide which player wins and display the result

stretch goal - use foreach loop to create array instead of writing our manually


//numbers from 2-10, Jack, Queen King, Ace
*/


function generateDeck(): array {
    $suits = ["hearts", "diamonds", "clubs", "spades"];
    $face_cards = ["Jack", "Queen", "King"];
    $deck = [];
    foreach($suits as $suit) {
        for($i = 2; $i < 11; $i++) {
            //$deck["$suit"."_"."$i"] = $i;
            $deck[] = ["suit" => "$suit", "card" => "$i", "value" => $i];
        }
        foreach($face_cards as $face_card) {
            //$deck["$suit"."_"."$face_card"] = 10;
            $deck[] = ["suit" => "$suit", "card" => "$face_card", "value" => 10];
        }
        //$deck["$suit"."_"."Ace"] = 11;
        $deck[] = ["suit" => "$suit", "card" => "Ace", "value" => 11];
    }
    return $deck;
}

function pickCard(array $deck): array {
    do {
        $cardIndexChosen = rand(0, 51); // minus one to show index of that card
    } while (array_key_exists($cardIndexChosen, $deck) != true); // check to see if card already chosen, if chosen pick again
    $pickedCard = $deck[$cardIndexChosen];
    return $pickedCard;
}

function removeCardFromDeck(array $deck, array $card) :array {
    $cardIndex = array_search($card, $deck);
    unset($deck[$cardIndex]);
    return $deck;
}

function calculatePoints(array $playerData, int $player):int {
    $numOfCards = count($playerData);
    $score = 0; // resets score for this round
    for($i = 0; $i < $numOfCards; $i++) {
        $score += $playerData[$i]["value"];
    }
    return $score;
    //return $points;
}

function calculateWinner(array $gameData, int $numPlayers): int {
    //set score to 0 if scored 22
    // compare who has highest score and delclare them the winner
    $scores = [];
    for($i = 1; $i < $numPlayers + 1; $i++) {
        if($gameData[$i]["score"] > 21) {
            $gameData[$i]["score"] = 0;
        }
        $scores[] = $gameData[$i]["score"];
    }
    $highestScore = array_keys($scores, max($scores));
    if(count($highestScore) > 1) {
        return -1;
    }
    $winner = $highestScore[0] + 1; // adding 1 so that answer is player number
    return $winner;
}

function play() {
    $numPlayers = 2;
    $numOfCardsDealt = 2;
    $gameData = []; // each player will be an item in the array, within that player will be their cards
    $deck = generateDeck();

    for($n = 1; $n < $numPlayers + 1; $n++) { // index starts at 1 so that player 1's score is at index 1
        for($i = 0; $i < $numOfCardsDealt; $i++) {
            $gameData[$n][] = pickCard($deck);
            $deck = removeCardFromDeck($deck, $gameData [$n][$i]);
        }
    }
    for($i = 1; $i < $numPlayers + 1; $i++) {
        $gameData[$i]["score"] = calculatePoints($gameData[$i], $i);
    }
    $outcome = calculateWinner($gameData, $numPlayers); // -1 is draw, otherwise it's the player who won

    $results = [$gameData, $outcome];
    return $results;
}


$playedGamedData = play();




$exampleGameData = [[
            [["suit" => "hearts", "card" => "jack", "value" => 10],["another card"],"score" => 0],
            ["another players data"]
            ],
        ["outcome data"]];

$player1FirstCardSuit = $playedGamedData[0][1][0]["suit"].".png";
$player1FirstCard = $playedGamedData[0][1][0]["card"];
$player1SecondCardSuit = $playedGamedData[0][1][1]["suit"].".png";
$player1SecondCard = $playedGamedData[0][1][1]["card"];

$player2FirstCardSuit = $playedGamedData[0][2][0]["suit"].".png";
$player2SecondCardSuit = $playedGamedData[0][2][1]["suit"].".png";
?>



<!DOCTYPE html>
<html lang="en-GB">

<head>
    <title>Encryption Service</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>
</head>

<body>

<header>

    <h1>BlackJack</h1>

</header>

<main>
    <section>
        <h2>Player 1 drew...</h2>
        <?php echo "<p>The $player1FirstCard of </p>" ?>
        <?php echo "<img src='$player1FirstCardSuit' alt='Player 1s first card'>" ?>
        <?php echo "<p>The $player1SecondCard of </p>" ?>
        <?php echo "<img src='$player1SecondCardSuit' alt='Player 1s first card'>" ?>
        <h2>Player 2 drew...</h2>
        <?php echo "<img src='$player2FirstCardSuit' alt='Player 1s first card'>" ?>
        <?php echo "<img src='$player2SecondCardSuit' alt='Player 1s first card'>" ?>
    </section>
    <section>
        <h2>The result</h2>
        <p>Player $winner wins.</p>
    </section>
</main>

</body>
</html>