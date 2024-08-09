<?php

namespace RobinThijsen\LaravelMonday\Builder;

use Closure;
use ErrorException;
use RobinThijsen\LaravelMonday\API\MondayApi;
use RobinThijsen\LaravelMonday\API\Token;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderFieldTypes;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\Exceptions\InvalidFieldException;
use RobinThijsen\LaravelMonday\Objects\Account;
use RobinThijsen\LaravelMonday\Objects\Block;
use RobinThijsen\LaravelMonday\Objects\Board;
use RobinThijsen\LaravelMonday\Objects\Item;

class Builder
{
    private const QUERYABLE_FIELDS = [
        'account',
        'assets',
        'docs',
        'boards',
        'workspaces',
        'docs',
        'items',
        'teams',
        'users',
    ];
    private const FINDABLE_FIELDS = [
        'assets',
        'docs',
        'boards',
        'workspaces',
        'docs',
        'items',
        'teams',
        'users',
    ];
    private const NAMESPACE = 'RobinThijsen\\LaravelMonday\\Objects\\';

    private $isUnique;
    private $query;
    private $temporaryParentClassName = [];

    private $params;
    private $fields;

    public function __construct($params, $isUnique)
    {
        if (is_null($params)) $params = [];

        $this->query = "";
        $this->params = $params;
        $this->isUnique = $isUnique;
        $this->fields = [];
    }

    public function getter($name)
    {
        return $this->{$name};
    }

    protected function setter($name, $value)
    {
        if (!property_exists($this, $name)) {
            throw new ErrorException("Property '{$name}' doesn't exist on type '" . self::class . "'.");
        }

        $this->{$name} = $value;
    }

    protected function checkFieldValidity($field)
    {
        $className = self::getClassName(get_called_class());
        $class = new $className;
        $array = array_merge($class::DEFAULT_FIELDS, $class::OBJECT_FIELDS, $class::UNIQUE_OBJECT_FIELDS);

        if (!in_array($field, $array)) {
            throw new InvalidFieldException("Field '{$field}' doesn't exist on class '{$className}'.");
        }
    }

    protected function isFieldValide($field)
    {
        $array = array_merge($this::DEFAULT_FIELDS, $this::OBJECT_FIELDS, $this::UNIQUE_OBJECT_FIELDS);

        if (in_array($field, $array)) {
            return true;
        }

        return false;
    }

    protected function isFieldAnObject($field)
    {
        $array = array_merge($this::OBJECT_FIELDS, $this::UNIQUE_OBJECT_FIELDS, $this::EXCEPTION_FIELDS);

        if (in_array($field, $array)) {
            return true;
        }

        return false;
    }

    protected function isAnObject($data)
    {
        foreach ($data as $key => $value) {
            if (is_string($key) && !is_array($value)) return true;
        }

        return false;
    }

    protected function callQuery($keyById)
    {
        $mondayAPI = new MondayApi();
        $token = new Token(config('monday.token'));
        $mondayAPI->setToken($token);
        $mondayAPI->setVersion(config('monday.version'));

        return $this->build($mondayAPI->customQuery($this->query), $keyById);
    }

    private function build($result, $keById)
    {
        if (!is_array($result)) return $result;

        $data = [];
        $objects = [];
        $className = $this::getClassName();

        if (isset($result[$this->objectName])) $data = $result[$this->objectName];
        else if (isset($result[$this->objectNamePlural])) $data = $result[$this->objectNamePlural];

        if (empty($data)) {
            $result['query'] = $this->query;
            $result['openBraquetCount'] = substr_count($this->query, '{');
            $result['closeBraquetCount'] = substr_count($this->query, '}');
            return $result;
        }

        if ($this->isUnique || $this->isAnObject($data)) return $className::instansiate($data[0], $this->query);

        foreach ($data as $object) {
            if ($keById && !$object['id']) throw new ErrorException('The object does not have an id field.');

            if ($keById) $objects[$object['id']] = $className::instansiate($object, $this->query);
            else $objects[] = $className::instansiate($object, $this->query);
        }

        return $objects;
    }

    protected static function instansiate($props, $query)
    {
        $className = self::getClassName(get_called_class());
        $self = new $className;
        $self->query = $query;

        foreach ($props as $key => $values) {
            if ($self->isFieldAnObject($key)) {
                $otherClassName = self::getClassNameBy($key);
                $data = $values;;

                if (array_key_exists($key, $self::EXCEPTION_FIELDS)) {
                    $data = $values[$self::EXCEPTION_FIELDS[$key]];
                    $key = $self::EXCEPTION_FIELDS[$key];
                }

                if (in_array($key, $self::UNIQUE_OBJECT_FIELDS)) {
                    $self->{$key} = $otherClassName::instansiate($data, $query);
                } else {
                    foreach ($data as $d) {
                        $self->{$key}[] = $otherClassName::instansiate($d, $query);
                    }
                }
            } else {
                $self->{$key} = $values;
            }
        }

        return $self;
    }

    public static function query()
    {
        $className = self::getClassName(get_called_class());
        $class = new $className;

        if (!in_array($class->objectNamePlural, self::QUERYABLE_FIELDS)
            && !in_array($class->objectName, self::QUERYABLE_FIELDS)) {
            throw new InvalidFieldException("Field '" . $class->objectName . "/" . $class->objectNamePlural . "' doesn't exist on type 'Query'.");
        }

        return new $className;
    }

    public static function find($id)
    {
        $className = self::getClassName(get_called_class());
        $class = new $className;
        if (!in_array($class->objectNamePlural, self::FINDABLE_FIELDS)
            && !in_array($class->objectName, self::FINDABLE_FIELDS)) {
            throw new InvalidFieldException("Field '" . $class->objectName . "/" . $class->objectNamePlural . "' doesn't accept 'id' arguments.");
        }

        if ($className::$idType == BuilderParamTypes::STRING) {
            return new $className(['id' => new BuilderParams('id', BuilderParamTypes::STRING, $id)]);
        }

        return new $className(['id' => new BuilderParams('id', BuilderParamTypes::INT, (int)$id)]);
    }

    public function with(...$fieldNames)
    {
        $parent = $this;

        if (!empty($this->temporaryParentClassName)) {
            $className = end($this->temporaryParentClassName);
            $parent = new $className;
        }

        foreach ($fieldNames as $fieldName) {
            $parent->checkFieldValidity($fieldName);

            $this->instansiateFieldBuilder($fieldName, $parent::class, BuilderFieldTypes::DEFAULT);
        }

        return $this;
    }

    public function withObject($fieldName, $params = [], $fields = [])
    {
        $parent = $this;

        if (!empty($this->temporaryParentClassName)) {
            $className = end($this->temporaryParentClassName);
            $parent = new $className;
        }

        if ($params instanceof Closure) {
            $this->temporaryParentClassName[] = $fieldName;

            $this->instansiateFieldBuilder($fieldName, $parent::class);

            $params($this);

            unset($this->temporaryParentClassName[array_key_last($this->temporaryParentClassName)]);

            return $this;
        } else {
            $realParams = [];
            $realFields = [];

            foreach ($params as $key => $value) {
                $realParams[] = new BuilderParams($key, $parent::PARAMS[$key], $value);
            }

            foreach ($fields as $field) {
                $this->instansiateFieldBuilder($field, $fieldName, BuilderFieldTypes::DEFAULT);
            }

            $this->instansiateFieldBuilder($fieldName, $parent::class, BuilderFieldTypes::OBJECT, $realParams, $realFields);
        }

        return $this;
    }

    public function withObjects($objects)
    {
        foreach ($objects as $object) {
            $this->withObject($object['fieldName'], $object['params'], $object['fields']);
        }

        return $this;
    }

    public function get(bool $keyById = false)
    {
        $this->initializeQuery($this->params, $this->fields);

        return $this->callQuery($keyById);
    }

    private function instansiateFieldBuilder($fieldName, $parent, $type = BuilderFieldTypes::OBJECT, $params = [], $fields = [])
    {
        $this->fields[] = new BuilderFields(
            $fieldName,
            $type,
            $type == BuilderFieldTypes::DEFAULT ? $parent : null,
            $type == BuilderFieldTypes::OBJECT ? $parent : null,
            $params,
            $fields
        );

        return true;
    }

    private static function getClassName($getCalledClass = null)
    {
        if (is_null($getCalledClass)) $getCalledClass = get_called_class();

        $separator = substr_replace("\'", "", -1);
        $temp = explode($separator, $getCalledClass);
        return self::NAMESPACE . end($temp);
    }

    private static function getClassNameBy($name)
    {
        return match ($name) {
            'account', 'accounts', 'creator', 'created_by' => \RobinThijsen\LaravelMonday\Objects\Account::class,
            'product', 'products', 'account_product' => \RobinThijsen\LaravelMonday\Objects\AccountProduct::class,
            'block', 'blocks' => \RobinThijsen\LaravelMonday\Objects\Block::class,
            'board', 'boards' => \RobinThijsen\LaravelMonday\Objects\Board::class,
            'column', 'columns' => \RobinThijsen\LaravelMonday\Objects\Column::class,
            'column_value', 'column_values' => \RobinThijsen\LaravelMonday\Objects\ColumnValue::class,
            'doc', 'docs' => \RobinThijsen\LaravelMonday\Objects\Doc::class,
            'group', 'groups', 'top_group' => \RobinThijsen\LaravelMonday\Objects\Group::class,
            'icon', 'icons' => \RobinThijsen\LaravelMonday\Objects\Icon::class,
            'item', 'items', 'items_page' => \RobinThijsen\LaravelMonday\Objects\Item::class,
            'plan', 'plans' => \RobinThijsen\LaravelMonday\Objects\Plan::class,
            'user', 'users' => \RobinThijsen\LaravelMonday\Objects\User::class,
            'workspace', 'workspaces' => \RobinThijsen\LaravelMonday\Objects\Workspace::class,
            'workspace_setting', 'workspace_settings' => \RobinThijsen\LaravelMonday\Objects\WorkspaceSetting::class,
            default => self::class,
        };
    }

    private function getAlias($className, $parentClassName)
    {
        if ($className == Account::class) {
            return match ($parentClassName) {
                Block::class => 'created_by',
                Board::class => 'creator',
                default => null,
            };
        }
    }

    /* -------------------
     * QUERY
    ------------------- */
    public function initializeQuery($params, $fields)
    {
        $this->params = $params;
        $this->fields = $fields;

        $name = $this->objectNamePlural;

        $this->query = $name . ' ';

        if (!empty($this->params)) $this->instantiateParams($this->params);

        $this->query .= '{ ';

        if (!empty($this->fields)) $this->instantiateFields();

        $this->endQuery();
    }

    private function instantiateParams($params)
    {
        $this->query .= '(';
        foreach ($params as $param) {
            $this->checkParamType($param);
        }

        $this->query = substr_replace($this->query, ') ', -2);
    }

    private function instantiateFields()
    {
        if (empty($this->temporaryParentClassName)) $this->temporaryParentClassName[] = $this::class;
        $currentClassName = end($this->temporaryParentClassName);

        foreach ($this->fields as $field) {
            if ($field->isAlreadyInitialized || ($field->className != $currentClassName && $field->parentClassName != $currentClassName)) continue;

            $name = $field->name;
            if ($field->type == BuilderFieldTypes::OBJECT) {
                $parent = new $field->parentClassName;
                $object = new $field->name;
                $name = $object->objectName;

                $aliasesName = $this->getAlias($object::class, $parent::class);
                if ($aliasesName) $name = $aliasesName;

                if (!$parent->isFieldValide($name)) {
                    $parent->checkFieldValidity($object->objectNamePlural);
                    $name = $object->objectNamePlural;
                }
            }

            $this->checkFieldExceptions($name);
            $field->isAlreadyInitialized = true;

            if ($field->type == BuilderFieldTypes::OBJECT) {
                if (!empty($field->params)) {
                    $this->instantiateParams($field->params);
                }

                $this->query .= '{ ';

                if ($this->stillHasFields($field->name)) {
                    $this->temporaryParentClassName[] = $field->name;
                    $this->instantiateFields();
                }
            }

            if (!$this->stillHasFields($currentClassName)) {
                if ($currentClassName == Item::class) {
                    $this->query .= '} ';
                }

                $this->query .= '} ';
                unset($this->temporaryParentClassName[array_key_last($this->temporaryParentClassName)]);
            }

            if ($this->stillHasFields()) {
                $this->instantiateFields();
            }
        }

        return true;
    }

    private function checkFieldExceptions($field)
    {
        switch ($field) {
            case 'items_page':
            case 'items':
            case 'item':
                $this->query .= 'items_page { items ';
                break;
            case 'product':
                $this->query .= 'account_product ';
                break;
            default:
                $this->query .= $field . " ";
                break;
        }
    }

    private function checkParamType($param)
    {
        if ($param->name == "id") $param->name = "ids";

        $this->query .= match ($param->type) {
            BuilderParamTypes::STRING => $param->name . ': "' . $param->value . '", ',
            BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::ARRAY_OF_ELEMENT => $param->name . ': [' . implode(', ', $param->value) . '], ',
            BuilderParamTypes::ARRAY_OF_STRING => $param->name . ': ["' . implode('", ', $param->value) . '"], ',
            BuilderParamTypes::BOOL => $param->name . ': ' . ($param->value ? 'true' : 'false') . ', ',
            default => "{$param->name}: {$param->value}, ",
        };
    }

    private function stillHasFields($currentClassName = null)
    {
        foreach ($this->fields as $field) {
            if (is_null($currentClassName)
                && !$field->isAlreadyInitialized) return true;
            else if (($field->className == $currentClassName || $field->parentClassName == $currentClassName)
                && !$field->isAlreadyInitialized) return true;
        }

        return false;
    }

    private function endQuery()
    {
        $openBraquetCount = substr_count($this->query, '{');
        $closeBraquetCount = substr_count($this->query, '}');

        $offset = -1;

        if ($openBraquetCount < $closeBraquetCount) {
            $offset = -(($closeBraquetCount - $openBraquetCount) * 2 + 1);
        } else if ($openBraquetCount > $closeBraquetCount) {
            for ($i = 1; $i <= ($openBraquetCount - $closeBraquetCount); $i++) {
                $this->query .= '} ';
            }
        }

        $this->query = substr_replace($this->query, '', $offset);
    }

    public function getQuery()
    {
        return $this->query;
    }
}
