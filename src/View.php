<?php

namespace Codeup\InteropMvc;

interface View
{
    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, $value);

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name);

    /**
     * @return string
     */
    public function render();

    /**
     * @param string $controllerName
     * @param string $actionName
     * @return string
     */
    public function renderAction(string $controllerName, string $actionName);

    /**
     * @param string $viewPath path of the view file without any extension
     * @return string
     */
    public function renderView(string $viewPath);

    /**
     * @return void
     */
    public function disable();
}
