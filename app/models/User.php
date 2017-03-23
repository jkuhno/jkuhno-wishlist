<?php
namespace Wishlist\App\Models;
use Wishlist\Core\Database\Model;
class User extends Model
{
    protected static $tableName = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $group_id;
}