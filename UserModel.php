<?php

namespace daymos\mvcFramework;

use daymos\mvcFramework\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}