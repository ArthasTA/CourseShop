<?php

namespace System\ORM;


use System\Database\Statement\Condition;
use System\Database\Statement\Select;
use System\Database\Connection;


/**
 * Class Repository
 * @package System\ORM
 *
 * @method static Repository getInstance()
 */
class Repository
{
    /**
     * @var \ReflectionClass
     */
    protected $reflection;

    /**
     * @var string
     */
    protected $storage;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * Repository constructor.
     * @param $modelClass
     */
    public function __construct($modelClass)
    {
        $this->reflection = new \ReflectionClass($modelClass);

        $docComment = $this->reflection->getDocComment();

        if (preg_match('/@table\((.+)\)/', $docComment, $matches) === 1) {
            $this->storage = $matches[1];
        }

        foreach ($this->reflection->getProperties() as $property) {
            if (preg_match('/@columnType\((.*)\)/', $property->getDocComment(), $tempResult)) {
                $this->columns[] = $property->getName();
            }
        }

    }

    /**
     * @param string
     * @return array string mo
     */
    public function getModels($directory = 'MVC/Models')
    {
        $classes = [];

        foreach (array_diff(scandir(APP_ROOT . $directory), array('..', '.')) as $file) {
            $class = str_replace('/', '\\', $directory) . '\\' . str_replace('.php', '', $file);
            if (class_exists($class)) {
                $classes[] = $class;
            }
        }
        return $classes;
    }

    /**
     * @param $model
     * @return int
     */
    public function save($model)
    {
        $statement = Connection::getInstance()
            ->insert()
            ->from($this->storage);

        $values = [];

        foreach ($this->columns as $column) {
            $property = $this->reflection->getProperty($column);
            $property->setAccessible(true);

            $value = $property->getValue($model);
            if ($value !== null) {
                $values[$property->getName()] = $value;
            }

            $property->setAccessible(false);
        }

        return $statement->values($values)->execute();

    }

    /**
     * Usage:
     * $repository = \System\ORM\Repository::getInstance();
     * $condition = new \System\Database\Statement\IndpndtConditions();
     * $condition = $condition->compare('id',10,'<')->closeCondition();
     * $repository->findBy(\MVC\Models\Tag::class,$condition,5);
     *
     * Also, this class supports the old condition class
     *
     * @param class
     * @param string $conditions
     * @param int $limit
     * @return array
     */
    public function findBy($criteria = [], $limit = null, $offset = null, $order = null)
    {
        $models = [];

        $statement = Connection::getInstance()
            ->select()
            ->from($this->storage);

        if ($limit !== null) {
            $statement->limit($limit);
        }

        if (empty($criteria) === false) {
             /** @var Condition $condition */
            $condition = $statement->where();

            foreach ($criteria as $field => $value) {
                $condition->conditionAnd()->compare($field, $value, '=');
            }

            /** @var Select $statement */
            $statement = $condition->closeCondition();
        }

        $rows = $statement->execute();

        foreach ($rows as $row) {
            $model = $this->reflection->newInstance();

            foreach ($this->columns as $column) {
                $reflectionProperty = $this->reflection->getProperty($column);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($model, $row[$column]);
                $reflectionProperty->setAccessible(false);
            }

            $models[] = $model;
        }

        return $models;
    }
}
