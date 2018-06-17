<?php
/**
 * Created by IntelliJ IDEA.
 * User: legra
 * Date: 6/17/2018
 * Time: 5:32 PM
 */

namespace App\Manager\Impl;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Manager\ManageableEntity;

/**
 * Class UserManager
 * @package App\Manager
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class UserManager extends BaseManager
{
    /**
     * UserManager constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        parent::__construct($logger, $entityManager, User::class);
    }

    /**
     * @return ManageableEntity
     */
    public function createEntity(): ManageableEntity
    {
        /** @var User $user */
        $user = parent::createEntity();
        $user->setHasFollowedBack(false);
        $user->setFollowedOn(new \DateTime());
        $user->setLikesGiven(0);
        $user->setLikesReceived(0);

        return $user;
    }

}