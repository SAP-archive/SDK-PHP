<?php

namespace RecastAI;

/**
 * Class Entity
 * @package RecastAI
 */
Class Entity
{

    /**
     * Entity constructor.
     * @param $name
     * @param $data
     */
    public function __construct($name, $data)
    {
        $this->name = $name;
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}