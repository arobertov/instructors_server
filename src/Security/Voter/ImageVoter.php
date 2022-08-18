<?php

namespace App\Security\Voter;

use App\Entity\Image;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ImageVoter extends \Symfony\Component\Security\Core\Authorization\Voter\Voter
{

    private VoterHelperInterface $voterHelper;

    public function __construct(VoterHelperInterface $voterHelper)
    {
        $this->voterHelper = $voterHelper;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Image && $this->voterHelper->handleAttribute($attribute);
    }


    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return $this->voterHelper->handleVoteOnAttribute($attribute,$subject,$token);
    }
}