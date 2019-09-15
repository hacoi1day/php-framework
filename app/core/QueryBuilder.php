<?php

namespace app\core;

use PDO;
use PDOException;
use app\core\Registry;
use app\core\AppException;

class QueryBuilder
{
    private $columns;
    private $from;
    private $distinct = false;
    private $joins;
    private $where;
    private $groups;
    private $having;
    private $orders;
    private $limit;
    private $offset;

    public function __construct($tableName)
    {
        $this->from = $tableName;
    }

    public static function table($tableName)
    {
        return new self($tableName);
    }

    public function select($columns)
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function distinct()
    {
        $this->distinct = true;
        return $this;
    }

    public function join($table, $first, $operator, $second, $type = 'inner')
    {
        $this->joins[] = [$table, $first, $operator, $second, $type];
        return $this;
    }

    public function leftJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'left');
    }

    public function rightJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second,'right');
    }

    public function where($column, $operator, $value, $boolean = 'and')
    {
        $this->where[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        return $this->where($column, $operator, $value,'or');
    }

    public function groupBy($columns)
    {
        $this->groups = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function having($column, $operator, $value, $boolean = 'and')
    {
        $this->having[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    public function orHaving($column, $operator, $value)
    {
        $this->having($column, $operator, $value,'or');
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orders[] = [$column, $direction];
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function get()
    {
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }

        $sql = $this->distinct ? 'SELECT DISTINCT ' : 'SELECT ';

        if (isset($this->columns) && is_array($this->columns)) {
            $sql .= implode(" ,", $this->columns);
        } else {
            $sql .= ' *';
        }

        $sql .= ' FROM ' . $this->from;

        if (isset($this->joins) && is_array($this->joins)) {
            foreach ($this->joins as $join) {
                switch (strtolower($join[4])) {
                    case 'inner':
                        $sql .= ' INNER JOIN';
                        break;
                    case 'left':
                        $sql .= ' LEFT JOIN';
                        break;
                    case 'right':
                        $sql .= ' RIGHT JOIN';
                        break;
                    default:
                        $sql .= ' INNER JOIN';
                }
            }
        }

        if (isset($this->where) && is_array($this->where)) {
            $sql .= ' WHERE';
            foreach ($this->where as $key => $where) {
                $sql .= " $where[0] $where[1] $where[2]";
                if ($key < count($this->where) - 1) {
                    $sql .= (strtolower($where[3]) === 'and') ? ' AND' : ' OR';
                }
            }
        }

        if (isset($this->groups) && is_array($this->groups)) {
            $sql .= ' GROUP BY ' . implode(' ', $this->groups);
        }

        if (isset($this->having) && is_array($this->having)) {
            $sql .= ' HAVING';
            foreach ($this->having as $key => $having) {
                $sql .= " $having[0] $having[1] $having[2]";
                if ($key < count($this->having) - 1) {
                    $sql .= (strtolower($having[3]) === 'and') ? ' AND' : ' OR';
                }
            }
        }

        if (isset($this->orders) && is_array($this->orders)) {
            $sql .= ' ORDER BY ';
            foreach ($this->orders as $key => $order) {
                $sql .= " $order[0] $order[1]";
                if ($key < count($this->orders) - 1) {
                    $sql .= ', ';
                }
            }
        }

        if (isset($this->limit)) {
            $sql .= " LIMIT $this->limit";
        }

        if (isset($this->offset)) {
            $sql .= " OFFSET $this->limit";
        }

        return $sql;
    }

}