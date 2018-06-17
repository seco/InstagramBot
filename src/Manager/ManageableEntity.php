<?php
/**
 * Created by IntelliJ IDEA.
 * User: legra
 * Date: 6/17/2018
 * Time: 5:33 PM
 */

namespace App\Manager;

/**
 * Interface ManageableEntity
 * @package App\Manager
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
interface ManageableEntity
{
    /**
     * @return string
     */
    public function __toString(): string;
}