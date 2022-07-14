<?php
namespace App\Entity;

class Vote
{
    protected $yeti_id;
    protected $user;
    protected $vote;
    protected $date;

    public function getYeti_id(): int
    {
        return $this->yeti_id;
    }

    public function setYeti_id(int $yeti_id): void
    {
        $this->yeti_id = $yeti_id;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }
    public function getVote(): int
    {
        return $this->vote;
    }

    public function setVote(int $vote): void
    {
        $this->vote = $vote;
    }
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }
}
?>