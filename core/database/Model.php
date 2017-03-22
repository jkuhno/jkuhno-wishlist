<?php

namespace Wishlist\Core\Database;

use Wishlist\Core\App;

abstract class Model
{
	protected static $primaryKey = 'id';
	protected static $tableName = NULL;

	private static function getTableName() {
		if(is_null(static::$tableName)) {
			return lcfirst(substr(strrchr(get_called_class(), "\\"), 1));
		}

		return static::$tableName;
	}

	public static function all($fields = [])
	{
		$selectFields = '*';
		if(count($fields) > 0) {
			$selectFields = implode(', ', $fields);
		}

		return App::get('database')
			->query("SELECT $selectFields FROM " . static::getTableName())
			->getAll(get_called_class());
	}
	public static function allOrdered($field, $id, $data)
	{
		$orderNames = implode(", ", $data);
		return App::get('database')
			->query("SELECT * FROM " . static::getTableName() . " WHERE " . $field . " = :id ORDER BY " . $orderNames)
			->bind(':id', $id)
			->getAll(get_called_class());
	}

	/* SELECT * FROM game WHERE $_SESSION['user_id'] = user_id ORDER BY releasedate ASC, name ASC
		
		$fieldNames = implode(', ', array_keys($data));
		$bindNames = ':' . implode(', :', array_keys($data));

		$statement = App::get('database')
			->query('INSERT INTO '
				. static::getTableName()
				. ' ('.$fieldNames.') VALUES (' . $bindNames .')');

		foreach($data as $key => $value) {
			$statement->bind(':'.$key, $value);
		}
	*/

	public static function find($id)
	{
		return App::get('database')
			->query("SELECT * FROM "
				. static::getTableName()
				. " WHERE " . static::$primaryKey . " = :id")
			->bind(':id', $id)
			->getOne(get_called_class());
	}

	public static function findWhere($field, $value)
	{
		return App::get('database')
			->query("SELECT * FROM "
				. static::getTableName()
				. " WHERE " . $field . " = :id")
			->bind(':id', $value)
			->getOne(get_called_class());
	}

	public static function create($data)
	{
		$fieldNames = implode(', ', array_keys($data));
		$bindNames = ':' . implode(', :', array_keys($data));

		$statement = App::get('database')
			->query('INSERT INTO '
				. static::getTableName()
				. ' ('.$fieldNames.') VALUES (' . $bindNames .')');

		foreach($data as $key => $value) {
			$statement->bind(':'.$key, $value);
		}

		$statement->execute();

		return App::get('database')->lastInsertId();
	}

    public static function createEmptyRow()
    {
        App::get('database')
            ->query('INSERT INTO '
                . static::getTableName()
                . ' () VALUES()')
            ->execute();
    }
	
	public static function delete($id)
	{
		App::get('database')
			->query('DELETE FROM '
				. static::getTableName()
				. ' WHERE ' . static::$primaryKey . ' = :id')
			->bind(':id', $id)
			->execute();
	}

	public static function update($id, $data)
	{
		$sql = 'UPDATE ' . static::getTableName() . ' SET ';
		foreach($data as $key => $value) {
			$sql .= $key . ' = :' . $key . ', ';
		}
		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE ' . static::$primaryKey . ' = :id';
		$statement = App::get('database')
			->query($sql);

		$statement->bind(':id', $id);
		foreach($data as $key => $value) {
			$statement->bind(':'.$key, $value);
		}

		$statement->execute();
	}

	public function destroy()
	{
		App::get('database')
			->query('DELETE FROM '
				. static::getTableName()
				. ' WHERE ' . static::$primaryKey . ' = :id')
			->bind(':id', $this->id)
			->execute();
	}
}