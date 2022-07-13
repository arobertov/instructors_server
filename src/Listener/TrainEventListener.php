<?php

namespace App\Listener;

use App\Entity\Event;
use DateTime;
use Symfony\Component\Security\Core\Security;

class TrainEventListener
{
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    public function prePersist(Event $event){
        if($this->security->getUser()){
            $event->setOwner($this->security->getUser());
        }
        //if($event->getDateCreated()===null){
         //
        //}
        $event->setDateCreated(new DateTime('now'));
        $event->setDateEdited(new DateTime('now'));
    }

    public function preUpdate(Event $event){
        if($event->getOwner()){
            return;
        }
        if($this->security->getUser()){
            $event->setOwner($this->security->getUser());
        }
        $event->setDateEdited(new DateTime('now'));
    }

    /**
     * @return Security
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * @param Security $security
     */
    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }
}