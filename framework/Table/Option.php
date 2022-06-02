<?php

    class Option
    {
        private string $clause;
        private string $key;
        private Array $value;
        private Array $data;
        private $options;
        private $query_options;

        public function __construct($option, $query_options = null)
        {
            $this->clause = $option['clause'];
            $this->key = $option['key'];
            if (isset($option['value'])) $this->value = $option['value'];
            $this->options = $option['options'];
            if (isset($option['data'])) $this->data = $option['data'];
            if (isset($query_options) && $query_options) $this->query_options = $query_options;
        }

        public function optionResolver(): string {
            switch($this->clause) {
                case 'WHERE': {
                    if (isset($this->data)) {
                        foreach ($this->data as $key => $value) {
                            $this->value[$key] = $this->query_options[$value];
                        }
                    }

                    return "WHERE ".$this->key." ". $this->options['character'] ." '".$this->value['value']."'";
                }
                case 'BETWEEN': {
                    return " BETWEEN ".$this->key." AND ".$this->value;
                }
            }
            return '';
        }
    }