<?php

    class Option
    {
        private string $clause;
        private string $key;
        private string $value;
        private $options;

        public function __construct($option)
        {
            $this->clause = $option['clause'];
            $this->key = $option['key'];
            $this->value = $option['value'];
            $this->options = $option['options'];
        }

        public function optionResolver(): string {
            switch($this->clause) {
                case 'WHERE': {
                    return "WHERE ".$this->key." ". $this->options['character'] ." '".$this->value."'";
                }
                case 'BETWEEN': {
                    return " BETWEEN ".$this->key." AND ".$this->value;
                }
            }
            return '';
        }
    }