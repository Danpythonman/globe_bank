<?php

    function is_blank($value) {
        return !isset($value) || trim($value) === '';
    }

    function is_present($value) {
        return !is_blank($value);
    }

    function has_length_greater_than($value, $minimum_length) {
        return strlen($value) > $minimum_length;
    }

    function has_length_less_than($value, $maximum_length) {
        return strlen($value) < $maximum_length;
    }

    function has_length_greater_than_or_equal_to($value, $minimum_length) {
        return strlen($value) >= $minimum_length;
    }

    function has_length_less_than_or_equal_to($value, $maximum_length) {
        return strlen($value) <= $maximum_length;
    }

    function has_length_equal_to($value, $length) {
        return strlen($value) == $length;
    }

    function has_length($value, $options) {
        if (isset($options['min'])) {
            if (!has_length_greater_than_or_equal_to($value, $options['min'])) {
                return false;
            }
        }

        if (isset($options['max'])) {
            if (!has_length_less_than_or_equal_to($value, $options['max'])) {
                return false;
            }
        }

        if (isset($options['exact'])) {
            if (!has_length_equal_to($value, $options['exact'])) {
                return false;
            }
        }

        return true;
    }

    function is_included_in($value, $set) {
        return in_array($value, $set);
    }

    function is_excluded_in($value, $set) {
        return !in_array($value, $set);
    }

    function contains_substring($value, $substring) {
        return strpos($value, $substring) !== false;
    }

    function is_valid_email($value) {
        $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';

        return preg_match($email_regex, $value) === 1;
    }

?>
