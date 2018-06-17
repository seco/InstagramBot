<?php
/**
 * Created by IntelliJ IDEA.
 * User: legra
 * Date: 6/17/2018
 * Time: 5:32 PM
 */

namespace App\Manager;

/**
 * Interface ManagerInterface
 * @package App\Manager
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
interface ManagerInterface
{
    /**
     * @return ManageableEntity
     */
    public function createEntity(): ManageableEntity;

    /**
     * @param ManageableEntity $entity
     * @return bool
     */
    public function saveEntity(ManageableEntity $entity): bool;

    /**
     * @param ManageableEntity $entity
     * @return bool
     */
    public function removeEntity(ManageableEntity $entity): bool;
}