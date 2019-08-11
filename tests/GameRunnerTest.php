<?php

declare(strict_types=1);

namespace Tests\UglyTriviaKata;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

final class GameRunnerTest extends TestCase
{
    use PHPMock;

    /** @test */
    public function oddIntegers(): void
    {
        $randomIntMock = $this->getFunctionMock('UglyTriviaKata', 'random_int');
        $randomIntMock
            ->expects($this->any())
            ->willReturnCallback(static function () {
                static $isRoll = true,
                       $isWrong = false;
                if ($isRoll) {
                    $result = 0;
                } else {
                    $result = $isWrong ? 1 : 7;
                    $isWrong = !$isWrong;
                }

                $isRoll = !$isRoll;
                return $result;
            })
        ;

        $this->expectOutputString(file_get_contents(__DIR__ . '/output.txt'));
        include __DIR__ . '/../src/GameRunner.php';
    }
}
