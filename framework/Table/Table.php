<?php
    require_once '../../src/utils/Dependency.php';
    require_once ROOTPATH . '/db/Connect.php';
    require_once ROOTPATH . '/framework/Table/Option.php';

    class Table
    {
        private Connect $conn;
        private Array $join;
        private Array $elements;
        private Array $options;

        public function __construct(Connect $conn, $join, $elements, $options) {
            $this->conn = $conn;
            $this->join = $join;
            $this->elements = $elements;
            $this->options = $options;
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
                $option = new Option($option);
                $query .= $option->optionResolver();
            }

            return $query;
        }

        public function run() {
            $query = $this->conn->getConnection()->prepare($this->queryValue());
            $query->execute();
            return $query->fetchAll();
        }

        public function build(): string {
            $value = '<table class="table">';
            $value .= '<thead class="thead">';
            $value .= '<tr class="head-row">';
            foreach ($this->elements as $element) {
                $value .= '<th class="head-cell"> <a href="/projekt4/?params=' . $element['value'] . '">' . $element['value'] . '</a></th>';
            }
            $value .= '<th></th> <th></th>';
            $value .= '</tr>';
            $value .= '</thead>';
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
    }