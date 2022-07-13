<?php
namespace App\Security\Voter;

use App\Entity\TrainFault;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TrainFaultVoter extends Voter
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
        return $subject instanceof TrainFault && $this->voterHelper->handleAttribute($attribute);
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