<?php
/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2018 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

namespace Lyrasoft\Luna\PageBuilder;

use Windwalker\Data\Data;

/**
 * The AddonType class.
 *
 * @property-read  string               type
 * @property-read  string               name
 * @property-read  string               description
 * @property-read  string               icon
 * @property-read  string               componentName
 * @property-read  string|AbstractAddon class
 * @property-read  string               langPrefix
 *
 * @since  __DEPLOY_VERSION__
 */
class AddonType extends Data
{
    /**
     * createInstance
     *
     * @param   array $data
     * @param string  $engine
     *
     * @return AbstractAddon
     */
    public function createInstance(array $data = [], $engine = 'edge')
    {
        $class = $this->class;

        return new $class($data, $engine);
    }
}
