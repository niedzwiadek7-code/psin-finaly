<?php
    require_once '../../src/utils/Dependency.php';
    require_once ROOTPATH . '/db/Connect.php';
    require_once ROOTPATH . '/framework/Table/Option.php';
    require_once ROOTPATH . '/framework/Table/FormCreator.php';
    require_once ROOTPATH . '/framework/Table/DataManager.php';

    class Table
    {
        private Connect $conn;
        private Array $join;
        private Array $elements;
        private Array $options;
        private $form;
        private $query_options;

        // TODO: zapytania do bazy danych - dodawanie + implementacja w stronie
        // TODO: zapytania do bazy danych - usuwanie + implementacja w stronie
        // TODO: zapytania do bazy danych - edycja + implementacja w stronie
        // TODO: obsługa błędów - wyświetlanie błędów w formularzu
        // TODO: zarządzanie sesją w formularzu

        public function __construct($db, $branch, $query_options) {
            $this->conn = new Connect($db);
            $this->join = Dependency::encodeJSON(
                Dependency::$path . "/src/data/" . $this->getTableName() . "/join.json"
            );
            $this->elements = Dependency::encodeJSON(
                Dependency::$path . "/src/data/" . $this->getTableName() . "/elements-" . $branch . ".json"
            );
            $this->options = Dependency::encodeJSON(
                Dependency::$path . "/src/data/" . $this->getTableName() . "/options-" . $branch . ".json"
            );
            $this->form = Dependency::encodeJSON(
                Dependency::$path . "/src/data/" . $this->getTableName() . "/form-" . $branch . ".json"
            );
            $this->query_options = $query_options;
        }

        public function getTableName(): string {
            return "";
        }

        public function queryValue(): string {
            $db = $this->getTableName();
            $query = "SELECT ";

            foreach($this->elements as $elem) {
                $query .= $elem['table'].".".$elem['column']." AS '".$elem['value']."', ";
            }

            $query = substr($query, 0, -2)." FROM ".$db;

            foreach($this->join as $join) {
                $query .= " INNER JOIN " . $join['table'] . " ON " . $join['table'] . '.' . $join['join_key'] . " = " . $db . '.' . $join['base_key'];
            }

            $query .= " ";

            foreach($this->options as $option) {
                $option = new Option($option, $this->query_options);
                $query .= $option->optionResolver();
            }

            return $query;
        }

        public function run() {
            // FIXME: Try - catch implementation
            $query = $this->conn->getConnection()->prepare($this->queryValue());
            $query->execute();
            return $query->fetchAll();
        }

        public function build(): string {
            $value = '<table class="table">';
            $value .= '<thead class="thead">';
            $value .= '<tr class="head-row">';
            // Budowanie nagłówka tabeli
            foreach ($this->elements as $element) {
                $value .= '<th class="head-cell"> <a href="/projekt4/?params=' . $element['value'] . '">' . $element['value'] . '</a></th>';
            }
            $value .= '<th></th> <th></th>';
            $value .= '</tr>';
            $value .= '</thead>';
            // Budowanie ciała tabeli
            $value .= '<tbody class="tbody">';
            foreach ($this->run() as $row) {
                $value .= '<tr class="body-row">';
                foreach ($this->elements as $element) {
                    $value .= '<td class="cell">' . $row[$element['value']] . '</td>';
                }
                $value .= '<td><a class="btn-edit" href="edit.php/?id='.$row[0].'"> Edytuj </a> </td>';
                $value .= '<td><a class="btn-delete" href="delete.php/?id='.$row[0].'"> Usuń </a> </td>';
                $value .= '</tr>';
            }
            $value .= '</tbody>';
            $value .= '</table>';

            return $value;
        }

        public function getFormCreator(): FormCreator {
            return new FormCreator($this->form, $this->conn);
        }

        private function translateRequest(): Array {
            $elements = $this->getFormCreator()->getElements();
            $_SESSION['object'] = [];
            $object = [];
            foreach ($elements as $element) {
                $object[$element['relatedTarget']] = $_GET[$element['name']];
                $_SESSION['object'][$element['name']] = $_GET[$element['name']];
            }
            return $object;
        }
        
        public function getDataManager(): DataManager {
            if (isset($_GET['flag']) && $_GET['flag']) {
                return new DataManager($this->conn, $this->getTableName(), $this->translateRequest());
            }   else {
                die('Wystąpił nieoczekiwany problem z serwerem');
            }
        }
    }