<?php
    require_once ROOTPATH . "/db/Connect.php";
    require_once ROOTPATH . "/framework/Table/DataManager.php";
    require_once ROOTPATH . "/src/tables/" . $_GET['table'] . ".php";
    require_once ROOTPATH . "/src/templates/Header.php";
    require_once ROOTPATH . "/src/templates/Footer.php";

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
//                        case 'success':
//                            $page .= $this->getTableCreator()->build();
//                            break;
                    }
                    break;
//                case 'edit':
//                    $page .= $this->getFormCreator()->build();
//                    break;
//                case 'delete':
//                    $page .= $this->getFormCreator()->build();
//                    break;
            }

            $page .= Footer::generateTable();
            return $page;
        }

        private function newDuringMode(): string {
            $page = $this->table->build();
            $page .= $this->table->getFormCreator()->build();
            return $page;
        }
    }