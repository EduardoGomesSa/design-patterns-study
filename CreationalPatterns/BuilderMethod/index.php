<?php

namespace RefactoringGuru\Builder\RealWorld;

interface SQLQueryBuilder {
    public function select(string $table, array $fields) : SQLQueryBuilder;

    public function where(string $field, string $value, string $operator = '=');

    public function limit(int $start, int $offset) : SQLQueryBuilder;

    public function getSQL() : string;
}