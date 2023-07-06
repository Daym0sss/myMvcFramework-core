<?php

namespace daymos\mvcFramework\db;

use daymos\mvcFramework\Application;
use daymos\mvcFramework\Model;

abstract class DbModel extends Model
{
    public static function tableName(): string
    {
        return '';
    }

    abstract public function attributes(): array;
    abstract public static function primaryKey(): string;

    public function save(): bool
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");
        foreach ($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        return $statement->execute();
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item)
        {
            $stmt->bindValue(":$key", $item);
        }
        $stmt->execute();

        return $stmt->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}