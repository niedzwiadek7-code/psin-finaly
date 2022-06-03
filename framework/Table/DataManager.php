<?php
    require_once '../../src/utils/Dependency.php';
    require_once ROOTPATH . '/db/Connect.php';

    class DataManager
    {
        private Connect $connect;
        private string $table;
        private string $primary;
        private Array $columns;
        private Array $object;

        public function __construct($connect, $table, $object)
        {
            $this->connect = $connect;
            $this->table = $table;
            $file = Dependency::encodeJSON(
                ROOTPATH . '/src/data/' . $table . '/columns.json'
            );
            $this->columns = $file['columns'];
            $this->primary = $file['primary'];
            $this->object = $object;
        }

        public function validateProperty($column): bool {
            $value = $this->object[$column['name']];
            $type = $column['type'];
            $validation = $column['validation'];

            if (isset($validation['required']) && $validation['required']) {
                if (!isset($value) || $value === '') {
                    $property = 'e_' . $column['form_name'];
                    $_SESSION[$property] = 'Ta wartość jest wymagana';
                    return false;
                }
            }

            switch ($type)  {
                case 'string': break;
                case 'int': {
                    if (!is_numeric($value)) {
                        $property = 'e_' . $column['form_name'];
                        $_SESSION[$property] = 'Ta wartość jest nieprawidłowa';
                        return false;
                    }
                } break;
                case 'date': {
                    if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $value)) {
                        $property = 'e_' . $column['form_name'];
                        $_SESSION[$property] = 'Ta wartość jest nieprawidłowa';
                        return false;
                    }
                } break;
            }

            if (isset($validation['minLength'])) {
                if (strlen($value) < $validation['minLength']) {
                    $property = 'e_' . $column['form_name'];
                    $_SESSION[$property] = 'Ta wartość jest za krótka';
                    return false;
                }
            }

            if (isset($validation['relatedTarget'])) {
                $query_options = array(
                    "key" => $value
                );

                $path = ROOTPATH . '/src/tables/' . $validation['relatedTarget'] . '.php';

                require_once $path;
                $table = new $validation['relatedTarget']('nb8', 'exists', $query_options);

                $result = $table->run();

                if (count($result) === 0) {
                    $property = 'e_' . $column['form_name'];
                    $_SESSION[$property] = 'Ta wartość jest nieprawidłowa';
                    return false;
                }
            }

            if (isset($validation['range'])) {
                switch ($validation['range']) {
                    case 'before': {
                        $actual_date = new DateTime();
                        if ($value > $actual_date->format('Y-m-d')) {
                            $property = 'e_' . $column['form_name'];
                            $_SESSION[$property] = 'Data musi być wcześniejsza od obecnej';
                            return false;
                        }
                    } break;
                    case 'after': {
                        $actual_date = new DateTime();
                        if ($value < $actual_date->format('Y-m-d')) {
                            $property = 'e_' . $column['form_name'];
                            $_SESSION[$property] = 'Data musi być późniejsza od obecnej';
                            return false;
                        }
                    } break;
                }
            }
            return true;
        }

        private function validate(): bool {
            $validationResult = true;
            foreach ($this->columns as $column) {
                if (!$this->validateProperty($column)) {
                    $validationResult = false;
                }
            }
            return $validationResult;
        }

        public function insert(): bool {
            function getName($value) {
                return $value['name'];
            }

            if (!$this->validate()) {
                return false;
            }

            try {
                $sql = 'INSERT INTO ' . $this->table . ' (';
                $sql .= implode(', ', array_map('getName', $this->columns)) . ')';
                $sql .= ' VALUES (';
                $sql .= ':' . implode(', :', array_map('getName', $this->columns)) . ')';
                $stmt = $this->connect->getConnection()->prepare($sql);
                foreach ($this->columns as $key) {
                    $stmt->bindValue(':' . $key['name'], $this->object[$key['name']]);
                }
                $stmt->execute();
                $_SESSION['insert'] += 1;
                return true;
            }   catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }


        }

        public function update(): bool {
            if (!$this->validate()) {
                return false;
            }

            try {
                $sql = 'UPDATE ' . $this->table . ' SET ';
                foreach ($this->columns as $property) {
                    $sql .= $property['name'] . ' = :' . $property['name'] . ', ';
                }
                $sql = substr($sql, 0, -2);
                $sql .= ' WHERE ';
                $sql .= $this->primary . ' = :' . $this->primary;
                $stmt = $this->connect->getConnection()->prepare($sql);
                foreach ($this->columns as $key) {
                    $stmt->bindValue(':' . $key['name'], $this->object[$key['name']]);
                }
                $stmt->bindValue(':' . $this->primary, $_GET['id']);
                $stmt->execute();
                $_SESSION['update'] += 1;
                return true;
            }   catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }

        }

        public static function delete($table, $connect): bool {
            try {
                $primary = Dependency::encodeJSON(
                    ROOTPATH . '/src/data/' . $table . '/columns.json'
                )['primary'];
                $sql = 'DELETE FROM ' . $table . ' WHERE ';
                $sql .= $primary . ' = :' . $primary;
                $stmt = $connect->getConnection()->prepare($sql);
                $stmt->bindValue(':' . $primary, $_GET['id']);
                $stmt->execute();
                $_SESSION['delete'] += 1;
                return true;
            }   catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }