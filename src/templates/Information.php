<?php

    class Information {
        public static function generateInformation($class, $info): string {
            switch ($class) {
                case 'success': {
                    $div = '<div class="success">';
                    $div .= '<p class="info-success">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/tables/generate.php?mode=new&stage=during&table=' . $_GET['table'] .'"> Wróć do strony głównej </a>';
                    $div .= '</div>';
                    return $div;
                }
                case 'delete': {
                    $div = '<div class="delete">';
                    $div .= '<p class="info-delete">' . $info . '</p>';
                    $div .= '<a class="back-to-main" href="/psin-finaly/public/tables/generate.php?mode=new&stage=during&table=' . $_GET['table'] .'"> Wróć do strony głównej </a>';
                    $div .= '<a class="confirm-delete" href="/psin-finaly/public/tables/generate.php?mode=delete&stage=success&table=' . $_GET['table'] .'&id=' . $_GET['id'] . '"> Usuń element </a>';
                    $div .= '</div>';
                    return $div;
                }
            }
            return '';
        }
    }