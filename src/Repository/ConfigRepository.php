<?php

/**
 * Part of starter project.
 *
 * @copyright      Copyright (C) 2021 __ORGANIZATION__.
 * @license        MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Repository;

use Lyrasoft\Luna\Entity\Config;
use Unicorn\Attributes\Repository;
use Unicorn\Repository\ListRepositoryInterface;
use Unicorn\Repository\ListRepositoryTrait;
use Unicorn\Repository\ManageRepositoryInterface;
use Unicorn\Repository\ManageRepositoryTrait;

/**
 * The Config class.
 */
#[Repository(entityClass: Config::class)]
class ConfigRepository implements ManageRepositoryInterface, ListRepositoryInterface
{
    use ManageRepositoryTrait;
    use ListRepositoryTrait;
}
