<?php

namespace App\Entity;


class TaskSearch
{
    /**
     * @var \DateTime|null
     */
    private $minDate;

    /**
     * @var \DateTime|null
     */
    private $maxDate;

    /**
     * @var boolean|null
     */
    private $isCompleted;

    /**
     * @return \DateTime|null
     */
    public function getMinDate(): ?\DateTime
    {
        return $this->minDate;
    }

    /**
     * @param \DateTime|null $minDate
     */
    public function setMinDate(?\DateTime $minDate): void
    {
        $this->minDate = $minDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getMaxDate(): ?\DateTime
    {
        return $this->maxDate;
    }

    /**
     * @param \DateTime|null $maxDate
     */
    public function setMaxDate(?\DateTime $maxDate): void
    {
        $this->maxDate = $maxDate;
    }

    /**
     * @return bool|null
     */
    public function getisCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    /**
     * @param bool|null $isCompleted
     */
    public function setIsCompleted(?bool $isCompleted): void
    {
        $this->isCompleted = $isCompleted;
    }
}