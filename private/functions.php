<?php

    function url_for($script_path) {
        if ($script_path[0] != '/') {
            $script_path  = "/" . $script_path;
        }

        return WWW_ROOT . $script_path;
    }

    function error_404() {
        header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
        exit();
    }

    function error_500() {
        header($_SERVER['SERVER_PROTOCOL'] . '500 Internal Server Error');
        exit();
    }

    function redirect_to($location) {
        header('Location: ' . $location);
        exit;
    }

    function display_errors($errors) {
        $output = '';

        if (isset($errors)) {
            $output .= <<< HTML
                <div class="errors">
                    <p>Please fix the following errors:
                    <ul>
            HTML;

            foreach ($errors as $error) {
                $error_safe_string = htmlspecialchars($error);

                $output .= <<< HTML
                    <li>$error_safe_string</li>
                HTML;
            }

            $output .= <<< HTML
                    </ul>
                </div>
            HTML;
        }

        return $output;
    }

?>
