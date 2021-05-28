<?php

namespace App\Core\Form;

use App\Core\Model;

class Form
{
    public static function begin($options)
    {
        echo "<form action='{$options['action']}' method='{$options['method']}'>";
        return new Form;
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new Field($model, $attribute);
    }
}
