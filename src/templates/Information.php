<?php

    class Information {
        public static function generateTableInformation($class, $info): string {
            switch ($class) {
                case 'success': {
                    $div = '<div class="success">';
                    $div .= '<p class="info-success">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/tables/generate.php?mode=new&stage=during&table=' . $_GET['table'] .'"> Wróć do tabeli </a>';
                    $div .= '</div>';
                    return $div;
                }
                case 'delete': {
                    $div = '<div class="delete">';
                    $div .= '<p class="info-delete">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/tables/generate.php?mode=new&stage=during&table=' . $_GET['table'] .'"> Wróć do tabeli </a>';
                    $div .= '<a class="confirm-delete" href="/psin-finaly/public/tables/generate.php?mode=delete&stage=success&table=' . $_GET['table'] .'&id=' . $_GET['id'] . '"> Usuń element </a>';
                    $div .= '</div>';
                    return $div;
                }
            }
            return '';
        }

        public static function generateUserInformation($class, $info): string {
            switch ($class) {
                case 'success': {
                    $div = '<div class="success">';
                    $div .= '<p class="info-success">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/tables/index.php"> Przejdź do strony głównej </a>';
                    $div .= '</div>';
                    return $div;
                }
                case 'logout': {
                    $div = '<div class="success">';
                    $div .= '<p class="info-success">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/user/login.php"> Przejdź do logowania </a>';
                    $div .= '</div>';
                    return $div;
                }
                case 'failure': {
                    $div = '<div class="delete">';
                    $div .= '<p class="info-delete">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/user/login.php"> Spróbuj jeszcze raz </a>';
                    $div .= '</div>';
                    return $div;
                }
            }
            return '';
        }

        public static function generateCRUDInfo() {
            $div = '<div class="crud-info">';
            $div .= '<h3 class="crud-info-title"> Dane sesji użytkownika </h3>';
            $div .= '<p class="session-info" style="display: block"> Identyfikator sesji: <strong>' . session_id() .' </strong></p>';
            $div .= '<p class="info-crud">';
            $div .= '<span class="legend"> Statystyka operacji w tabeli </span>';
            $div .= '<ul class="crud-info-list">';
            $div .= '<li class="select"> wyszukiwanie: <b>' . $_SESSION['select'] . ' </b> </li>';
            $div .= '<li class="insert"> dodawanie: <b>' . $_SESSION['insert'] . ' </b> </li>';
            $div .= '<li class="update"> edytowanie: <b>' . $_SESSION['update'] . ' </b> </li>';
            $div .= '<li class="delete"> usuwanie: <b>' . $_SESSION['delete'] . '</b> </li>';
            $div .= '</ul>';
            $div .= '</p>';
            $div .= '</div>';
            return $div;
        }
    }