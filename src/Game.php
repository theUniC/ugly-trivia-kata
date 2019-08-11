<?php

declare(strict_types=1);

namespace UglyTriviaKata;

class Game
{
    use PublishesEvents;

    private const POP_POSITIONS         = [0, 4, 8];
    private const SCIENCE_POSITIONS     = [1, 5, 9];
    private const SPORTS_POSITIONS      = [2, 6, 10];

    private const PURSES_TO_WIN = 6;

    private const MAX_POSITIONS = 11;

    private $players        = array();
    private $places         = array(0);
    private $purses         = array(0);
    private $inPenaltyBox   = array(0);

    private $popQuestions       = array();
    private $scienceQuestions   = array();
    private $sportsQuestions    = array();
    private $rockQuestions      = array();

    private $currentPlayer = 0;
    private $isGettingOutOfPenaltyBox;

    public function __construct()
    {
        $this->generateQuestions();
    }

    public function add(string $playerName): bool
    {
        $this->players[] = $playerName;
        $players = $this->howManyPlayers();
        $this->places[$players] = 0;
        $this->purses[$players] = 0;
        $this->inPenaltyBox[$players] = false;

        $this->publishThat(
            NewPlayerWasAdded::ofName($playerName, $players)
        );

        return true;
    }

    public function roll(): void
    {
        $roll = random_int(0, 5) + 1;

        $this->publishThat(
            DiceWasRolled::withScoreOf($roll, $this->currentPlayerName())
        );

        $moved = $this->moveForwardCurrentPlayerTo($roll);

        if ($moved) {
            $this->askQuestionAbout($this->currentCategory());
        }
    }

    public function correctAnswer(): bool
    {
        if ($this->isCurrentPlayerInPenaltyBox() && !$this->isGettingOutOfPenaltyBox) {
            $this->nextPlayer();
            return true;
        }

        $this->publishThat(
            new PlayerAnsweredCorrectly($this->currentPlayerName(), ++$this->purses[$this->currentPlayer])
        );

        $winner = $this->didPlayerWin();

        $this->nextPlayer();

        return $winner;
    }

    public function wrongAnswer(): bool
    {
        $this->publishThat(new PlayerAnsweredIncorrectly($this->currentPlayerName()));

        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->nextPlayer();

        return true;
    }

    public function run(): void
    {
        do {
            $this->roll();
            $notEndGame = $this->answerQuestion();
        } while ($notEndGame);
    }

    private function answerQuestion(): bool
    {
        return random_int(0, 9) !== 7 ? $this->correctAnswer() : $this->wrongAnswer();
    }

    private function howManyPlayers(): int
    {
        return count($this->players);
    }

    private function askQuestionAbout($category): void
    {
        switch ($category) {
            case 'Pop':
                $question = array_shift($this->popQuestions);
                break;
            case 'Science':
                $question = array_shift($this->scienceQuestions);
                break;
            case 'Sports':
                $question = array_shift($this->sportsQuestions);
                break;
            default:
                $question = array_shift($this->rockQuestions);
        }

        $this->publishThat(new QuestionWasSelected($question, $category));
    }

    private function currentCategory(): string
    {
        $place = $this->places[$this->currentPlayer];

        if (in_array($place, self::POP_POSITIONS, true)) {
            return 'Pop';
        }

        if (in_array($place, self::SCIENCE_POSITIONS, true)) {
            return 'Science';
        }

        if (in_array($place, self::SPORTS_POSITIONS, true)) {
            return 'Sports';
        }

        return 'Rock';
    }

    private function didPlayerWin(): bool
    {
        return self::PURSES_TO_WIN !== $this->purses[$this->currentPlayer];
    }

    private function isCurrentPlayerInPenaltyBox()
    {
        return $this->inPenaltyBox[$this->currentPlayer];
    }

    private function nextPlayer(): void
    {
        $this->currentPlayer++;

        if (count($this->players) === $this->currentPlayer) {
            $this->currentPlayer = 0;
        }
    }

    private function generateQuestions(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $this->popQuestions[]       = 'Pop Question ' . $i;
            $this->scienceQuestions[]   = 'Science Question ' . $i;
            $this->sportsQuestions[]    = 'Sports Question ' . $i;
            $this->rockQuestions[]      = 'Rock Question ' . $i;
        }
    }

    private function moveForwardCurrentPlayerTo(int $newPosition): bool
    {
        $isCurrentPlayerInPenaltyBox = $this->isCurrentPlayerInPenaltyBox();
        $canGetOutOfPenaltyBox = 0 !== $newPosition % 2;

        if ($isCurrentPlayerInPenaltyBox && !$canGetOutOfPenaltyBox) {
            $this->publishThat(new PlayerWasUnableToMoveOutFromPenaltyBox($this->currentPlayerName()));
            $this->isGettingOutOfPenaltyBox = false;
            return false;
        }

        if ($isCurrentPlayerInPenaltyBox && $canGetOutOfPenaltyBox) {
            $this->isGettingOutOfPenaltyBox = true;
            $this->publishThat(new PlayerWasMovedOutFromPenaltyBox($this->currentPlayerName()));
        }

        $this->places[$this->currentPlayer] += $newPosition;

        if ($this->places[$this->currentPlayer] > self::MAX_POSITIONS) {
            $this->places[$this->currentPlayer] -= 12;
        }

        $this->publishThat(new PlayerWasMovedToNewPosition($this->currentPlayerName(), $this->places[$this->currentPlayer]));

        return true;
    }

    private function currentPlayerName(): string
    {
        return $this->players[$this->currentPlayer];
    }
}
