<?php
    interface Table
    {
        public function getTableName();

        // @param array[array] elements ($elements[elem] = [ table, column, value_column ]
        // @param array[array] $options  ($options[elem] = [ clause, key, value? ])

        public function queryValue($elements, $options);

        public function run($query);

        public function build($results);
    }