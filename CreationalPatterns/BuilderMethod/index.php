<?php

namespace RefactoringGuru\Builder\RealWorld;

interface SQLQueryBuilder {
    public function select(string $table, array $fields) : SQLQueryBuilder;

    public function where(string $field, string $value, string $operator = '=') : SQLQueryBuilder;

    public function limit(int $start, int $offset) : SQLQueryBuilder;

    public function getSQL() : string;
}

class MysqlQueryBuilder implements SQLQueryBuilder {
    protected $query;

    protected function reset() : void {
        $this->query = new \stdClass;
    }

    public function select(string $table, array $fields) : SQLQueryBuilder {
        $this->reset();
        $this->query->base = "SELECT ". implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    public function where(string $field, string $value, string $operator = '=') : SQLQueryBuilder {
        if(!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception('WHERE can only be add to select, update or delete');
        }

        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset) : SQLQueryBuilder {
        if(!in_array($this->query->type, ['select'])) {
            throw new \Exception('LIMIT can be added to SELECT');
        }
        $this->query->limit = 'LIMIT '. $start . ', ' . $offset;

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if(!empty($query->where)){
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }

        if(isset($query->limit)) {
            $sql .= $query->limit;
        }

        $sql .= ';';
        return $sql;
    }
}

class PostgresQueryBuilder extends MysqlQueryBuilder {
    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

        return $this;
    }
}