<?php
    require_once '../../src/utils/Dependency.php';
    require_once ROOTPATH . '/db/Connect.php';

    class FormCreator
    {
        private string $method;
        private string $action;
        private Array $btn_word;
        private string $name_form;
        private Array $title;
        private string $legend;
        private array $elements;
        private Connect $conn;

        public function __construct($form, $conn)
        {
            $this->method = $form['method'];
            $this->action = $form['action'];
            $this->btn_word = $form['btn-word'];
            $this->name_form = $form['name-form'];
            $this->legend = $form['legend'];
            $this->title = $form['title'];
            $this->elements = $form['elements'];
            $this->conn = $conn;
        }

        private function generateArray($options): Array {
            $path = ROOTPATH . '/src/tables/' . $options['table'] . '.php';
            require_once $path;

            $table = new $options['table']('nb8', $options['branch']);
            return $table->run();
        }

        private function resolveElement($element): string {
            switch ($element['marker']) {
                case "input": {
                    $value = '<p>';
                    $value .= '<label for="' . $element['name'] . '">' . $element['label'] . '</label>';
                    $value .= '<input';
                    $value .= ' type="' . $element['type'] . '"';
                    $value .= ' name="' . $element['name'] . '"';
                    $value .= ' id="' . $element['name'] . '"';
                    $value .= ' class="input"';
                    if ($element['options']['isRequired']) {
                        $value .= ' required';
                    }
                    $value .= '>';
                    $value .= '</p>';
                    return $value;
                }
                case "select": {
                    $value = '<p>';
                    $value .= '<label for="' . $element['name'] . '">' . $element['label'] . '</label>';
                    $value .= '<select';
                    $value .= ' name="' . $element['name'] . '"';
                    $value .= ' id="' . $element['name'] . '"';
                    $value .= ' class="select"';
                    $value .= '>';

                    $dictionary = $this->generateArray($element['options']);
                    foreach ($dictionary as $word) {
                        $value .= '<option value="' . $word['key'] . '">' . $word['value'] . '</option>';
                    }

                    $value .= '</select>';
                    $value .= '</p>';
                    return $value;

                }
                case "datalist": {
                    $value = '<p>';
                    $value .= '<label for="' . $element['name'] . '">' . $element['label'] . '</label>';
                    $value .= '<input';
                    $value .= ' list = "list-' . $element['name'] . '"';
                    $value .= ' type="' . $element['type'] . '"';
                    $value .= ' name="' . $element['name'] . '"';
                    $value .= ' id="' . $element['name'] . '"';
                    $value .= ' class="input"';
                    if ($element['options']['isRequired']) {
                        $value .= ' required';
                    }
                    $value .= '>';
                    $value .= '<datalist id="list-' . $element['name'] . '">';

                    $dictionary = $this->generateArray($element['options']);

                    $values = explode(" ", $element['options']['value']);

                    foreach ($dictionary as $word) {
                        $value .= '<option value="' . $word['key'] . '">';
                        foreach ($values as $key) {
                            $value .= $word[$key] . ' ';
                        }
                        $value .= '</option>';
                    }

                    $value .= '</datalist>';
                    $value .= '</p>';
                    return $value;
                }
                case 'textarea': {
                    $value = '<p>';
                    $value .= '<label for="' . $element['name'] . '">' . $element['label'] . '</label>';
                    $value .= '<textarea';
                    $value .= ' name="' . $element['name'] . '"';
                    $value .= ' id="' . $element['name'] . '"';
                    $value .= ' class="textarea"';
                    $value .= '></textarea>';
                    $value .= '</p>';
                    return $value;
                }
            }
            return '';
        }

        private function buttonLogic(): string {
            $logic = '<script type="text/javascript">';
            $logic .= "const btnNew = document.querySelector('.btn-new');";
            $logic .= "const form = document.querySelector('#form');";
            $logic .= "form.style.display = 'none';";
            $logic .= "btnNew.addEventListener('click', () => {";
            $logic .= "btnNew.style.display = 'none';";
            $logic .= "form.style.display = 'block';";
            $logic .= "});";
            $logic .= '</script>';
            return $logic;
        }

        public function build(): string
        {
            $mode = $_SESSION['mode'];
            $form = '<button class="btn-new" type="button">' . $this->btn_word[$mode] . '</button>';
            $form .= '<div id="form">';
            $form .= '<h3 class="title">' . $this->title[$mode] . '</h3>';
            $form .= '<form method="' . $this->method . '" action="' . $this->action . '">';
            $form .= '<fieldset class="data">';
            $form .= '<legend class="legend">' . $this->legend . '</legend>';
            foreach ($this->elements as $element) {
                $form .= $this->resolveElement($element);
            }
            $form .= '</fieldset>';
            $form .= '<input type="submit" value="' . $this->btn_word[$mode] . '">';
            $form .= '<input type="reset" value="Usuń dane">';
            $form .= '</form>';
            $form .= '</div>';
            $form .= $this->buttonLogic();

            unset($_SESSION['mode']);
            unset($_SESSION['object']);

            return $form;
        }
    }