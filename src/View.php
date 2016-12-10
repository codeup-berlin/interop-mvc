<?php

namespace Codeup\InteropMvc;

interface View
{
    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value);

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name);

    /**
     * @return string
     */
    public function render();
}
