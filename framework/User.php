<?php
    require_once ROOTPATH . '/src/tables/UserTable.php';

    class User
    {
        private UserTable $table;
        private ?Array $query;

        public function __construct($query)
        {
            $branch = isset($_SESSION['email']) ? 'get' : 'get-login';
            $this->table = new UserTable(DATABASE, $branch, $query);
            $this->query = $query;
        }

        public function login(): bool
        {
            $user = $this->table->run();
            $password = $_POST['password'];

            if (count($user) >= 1) {
                $user = $user[0];
                if (password_verify($password, $user['password'])) {
                    $_SESSION['email'] = $user['email'];
                    $user_save = new User($this->query);
                    $user_save->saveUserToSession();
                    return true;
                }
            }

            return false;
        }

        private function saveUserToSession() {
            $user = $this->table->run();
            $user = $user[0];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['rule'] = $user['rule'];
            $_SESSION['registerdate'] = $user['registerdate'];

            $_SESSION['select'] = 0;
            $_SESSION['insert'] = 0;
            $_SESSION['update'] = 0;
            $_SESSION['delete'] = 0;
        }

        public static function deleteUserFromSession() {
            unset($_SESSION['email']);
            unset($_SESSION['firstname']);
            unset($_SESSION['lastname']);
            unset($_SESSION['rule']);
            unset($_SESSION['registerdate']);

            unset($_SESSION['select']);
            unset($_SESSION['insert']);
            unset($_SESSION['update']);
            unset($_SESSION['delete']);
            session_destroy();
        }

        public function getUserTable(): UserTable
        {
            return $this->table;
        }

        public static function verifyUser(Array $acceptedRules, string $deniedPage): void
        {
            if (!isset($_SESSION['rule']) || !in_array($_SESSION['rule'], $acceptedRules)) {
                header('Location: ' . $deniedPage);
                exit();
            }
        }

        public static function directToContent(): void {
            if (isset($_SESSION['email'])) {
                header('Location: /psin-finaly/public/tables/index.php');
                exit();
            }
        }

        public static function checkRequest(): void {
            if (!isset($_POST['email'])) {
                header('Location: /psin-finaly/public/user/login.php');
                exit();
            }
        }
    }