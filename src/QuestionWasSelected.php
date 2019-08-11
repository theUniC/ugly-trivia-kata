<?php

declare(strict_types=1);

namespace UglyTriviaKata;

use Ddd\Domain\DomainEvent;

final class QuestionWasSelected implements DomainEvent
{
    /**
     * @var string
     */
    private $question;

    /**
     * @var string
     */
    private $category;

    public function __construct(string $question, string $category)
    {
        $this->question = $question;
        $this->category = $category;
    }

    public function question(): string
    {
        return $this->question;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function occurredOn(): \DateTime
    {
        return new \DateTime();
    }
}
