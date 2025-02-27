<?php

/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Auth\Profile;

use Hybridauth\Adapter\AdapterInterface;

/**
 * Interface ProfileHandlerInterface
 */
interface ProfileHandlerInterface
{
    public function handle(AdapterInterface $adapter): array;

    public function getLoginName(): string;
}
