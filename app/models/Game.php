<?php
class Game extends Model
{
    protected static $tablename = 'game';

    public $id;
    public $name;
    public $releasedate;
}