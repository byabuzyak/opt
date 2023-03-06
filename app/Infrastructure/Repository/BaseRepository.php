<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use SplObserver;

class BaseRepository implements \SplSubject
{
    /**
     * @var array
     */
    private array $observers = [];

    public function __construct(protected EntityManager $entityManager)
    {
    }

    /**
     * @param SplObserver $observer
     * @param string $event
     * @return void
     */
    public function attach(SplObserver $observer, string $event = '*'): void
    {
        $this->observers[$event][] = $observer;
    }

    /**
     * @param SplObserver $observer
     * @param string $event
     * @return void
     */
    public function detach(SplObserver $observer, string $event = '*'): void
    {
        foreach ($this->getObservers($event) as $name => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$name]);
            }
        }
    }

    /**
     * @param string $event
     * @param mixed $data
     * @return void
     */
    public function notify(string $event = '*', mixed $data = null): void
    {
        /** @var \SplObserver $observer */
        foreach ($this->getObservers($event) as $observer) {
            $observer->update($this, $data);
        }
    }

    /**
     * @param string $event
     * @return array
     */
    public function getObservers(string $event): array
    {
        return $this->observers[$event];
    }
}