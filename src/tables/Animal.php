<?php
    require_once '../utils/Dependency.php';
    require_once '../../framework/Table/Table.php';
    require_once '../../db/Connect.php';

    class Animal extends Table
    {
        private Connect $conn;
        private $join;
        private $elements;
        private $options;

        public function __construct(Connect $conn, $join, $elements, $options)
        {
            parent::__construct($conn, $join, $elements, $options);
        }

        public function getTableName(): string
        {
            return "Zwierzatko";
        }
    }

    $animal = new Animal(new Connect('nb8'),
        Dependency::encodeJSON(
            Dependency::$path . '/src/data/Animal/join.json'
        ),
        Dependency::encodeJSON(
            Dependency::$path . "/src/data/Animal/elements-main.json"
        ),
        Dependency::encodeJSON(
            Dependency::$path . "/src/data/Animal/options-main.json"
        )
    );

    echo $animal->build();