<?php
/**
 * Created by IntelliJ IDEA.
 * User: legra
 * Date: 6/17/2018
 * Time: 5:39 PM
 */

namespace App\Manager\Impl;


use App\Manager\ManageableEntity;
use App\Manager\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;

/**
 * Class BaseManager
 * @package App\Manager\Impl
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
abstract class BaseManager implements ManagerInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * BaseManager constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @param string $targetClass
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager, string $targetClass)
    {
        $this->logger        = $logger;
        $this->entityManager = $entityManager;
        $this->entityClass   = $targetClass;
    }


    /**
     * @return ManageableEntity
     */
    public function createEntity(): ManageableEntity
    {
        try {
            $this->logger->debug(
                'Creating new entity from manager.',
                array('method' => 'createEntity', 'class' => self::class)
            );
            $r = new \ReflectionClass($this->entityClass);
            /** @var ManageableEntity $instance */
            $instance = $r->newInstance();
            return $instance;
        } catch (\ReflectionException $e) {
            $this->logger->critical('Failed to instantiate class.', array(
                'entity class' => $this->entityClass,
                'method'       => 'createEntity',
                'class'        => self::class
            ));
            die();
        }
    }

    /**
     * @param ManageableEntity $entity
     * @return bool
     */
    public function saveEntity(ManageableEntity $entity): bool
    {
        $this->logger->debug(
            'Saving entity to database.',
            array('entity' => $entity->__toString(), 'method' => 'saveEntity', 'class' => self::class)
        );
        if (!is_a($entity, $this->entityClass))
            return $this->onWrongEntityType($entity);

        try {
            if (!$this->entityManager->contains($entity)) $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @param ManageableEntity $entity
     * @return bool
     */
    public function removeEntity(ManageableEntity $entity): bool
    {
        $this->logger->debug(
            'Removing entity from database.',
            array('entity' => $entity->__toString(), 'method' => 'removeEntity', 'class' => self::class)
        );
        if (!is_a($entity, $this->entityClass))
            return $this->onWrongEntityType($entity);

        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @return bool
     */
    private function onWrongEntityType(object $entity): bool
    {
        $this->logger->emergency(
            'Wrong entity type in manager parameter.',
            array('entity type' => get_class($entity), 'method' => 'onWrongEntityType', 'class' => self::class)
        );
        return false;
    }

}