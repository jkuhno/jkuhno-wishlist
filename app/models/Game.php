<?php

namespace Wishlist\App\Models;

use Wishlist\Core\Database\Model;

class Game extends Model
{
    protected static $tablename = 'game';

    public $id;
    public $name;
    public $releasedate;
}