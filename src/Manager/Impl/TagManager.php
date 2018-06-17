<?php
/**
 * Created by IntelliJ IDEA.
 * User: legra
 * Date: 6/17/2018
 * Time: 5:32 PM
 */

namespace App\Manager\Impl;


use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class TagManager
 * @package App\Manager
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class TagManager extends BaseManager
{
    /**
     * UserManager constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        parent::__construct($logger, $entityManager, Tag::class);
    }
}