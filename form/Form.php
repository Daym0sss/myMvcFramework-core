<?php

namespace daymos\mvcFramework\form;

use daymos\mvcFramework\Model;

class Form
{
    public static function begin($action, $method): Form
    {
        echo "<form action='$action'  method='$method'>";

        return new Form();
    }

    public static function end(): string
    {
        return '</form>';
    }

    public function field(Model $model, $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}