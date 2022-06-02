<?php

use JetBrains\PhpStorm\Pure;

require_once ROOTPATH . "/db/Connect.php";
    require_once ROOTPATH . "/framework/Table/DataManager.php";
    require_once ROOTPATH . "/src/tables/" . $_GET['table'] . ".php";
    require_once ROOTPATH . "/src/templates/Header.php";
    require_once ROOTPATH . "/src/templates/Footer.php";
    require_once ROOTPATH . "/src/templates/Information.php";

    class TableTemplate
    {
        private string $mode;
        private $table;
        private string $stage;
        private ?DataManager $dataManager = null;

        public function __construct() {
            $this->mode = $_GET['mode'];
            $_SESSION['mode'] = $this->mode;
            $this->table = new $_GET['table'](DATABASE, 'main', null);
            $this->stage = $_GET['stage'];

            if (isset($_GET['flag']) && $_GET['flag']) {
                $this->dataManager = $this->table->getDataManager();
                switch ($this->mode) {
                    case 'new': {
                        if ($this->dataManager->insert()) {
                            $this->stage = 'success';
                        }
                    } break;
                    case 'edit': {
                        if ($this->dataManager->update()) {
                            $this->stage = 'success';
                        }
                    } break;
                }
            }
        }

        function __destruct() {
            unset($_SESSION['mode']);
            unset($_SESSION['object']);
        }

        public function build(): string {
            $page = Header::generateTable($this->table->getTableName());

            switch ($this->mode) {
                case 'new':
                    switch ($this->stage) {
                        case 'during':
                            $page .= $this->newDuringMode();
                            break;
                        case 'success':
                            $page .= $this->newSuccessMode();
                            break;
                    }
                    break;
                case 'edit':
                    switch ($this->stage) {
                        case 'during':
                            $page .= $this->editDuringMode();
                            break;
                        case 'success':
                            $page .= $this->editSuccessMode();
                            break;
                    }
                    break;
                case 'delete':
                    switch ($this->stage) {
                        case 'during':
                            $page .= $this->deleteDuringMode();
                            break;
                        case 'success':
                            $page .= $this->deleteSuccessMode();
                            break;
                    }
                    break;
            }

            $page .= Footer::generateTable();
            return $page;
        }

        private function newDuringMode(): string {
            $page = $this->table->build();
            $page .= $this->table->getFormCreator()->build();
            return $page;
        }

        private function newSuccessMode(): string {
            return Information::generateInformation('success', 'Dodano nowy rekord');
        }

        private function editDuringMode(): string {
            // TODO: Try - catch implementation
            $table_get = new $_GET['table'](DATABASE, 'get', array(
                "key" => $_GET['id']
            ));
            $_SESSION['object'] = $table_get->run()[0];
            return $this->table->getFormCreator()->build();
        }

        private function editSuccessMode(): string {
            return Information::generateInformation('success', 'Zaktualizowano rekord o id: ' . $_GET['id']);
        }

        private function deleteDuringMode(): string {
            return Information::generateInformation('delete', 'Czy na pewno chcesz usunąć rekord o id: ' . $_GET['id']);
        }

        private function deleteSuccessMode(): string {
            DataManager::delete($this->table->getTableName(), $this->table->getConnection());
            return Information::generateInformation('success', 'Usunięto rekord o id: ' . $_GET['id']);
        }
    }