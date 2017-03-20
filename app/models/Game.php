<?php
class Game extends Model
{
    protected static $tablename = 'games';

    public $id;
    public $name;
    public $releasedate;
}