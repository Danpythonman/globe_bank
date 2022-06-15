<?php

    function validate_subject($subject) {
        $errors = [];

        if (is_blank($subject['menu_name'])) {
            $errors[] = 'Name cannot be blank.';
        } elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
            $errors[] = 'Name must be between 2 and 255 characters.';
        }

        $position_int = (int) $subject['position'];

        if ($position_int <= 0) {
            $errors[] = 'Position must be greater than 0';
        } elseif ($position_int <= 999) {
            $errors[] = 'Position must be less than 1000';
        }

        $visible_string = (string) $subject['visible'];

        if (!is_included_in($visible_string, ['0', '1'])) {
            $errors[] = 'Visible must be true or false.';
        }

        return $errors;
    }

    function find_all_subjects() {
        global $db;

        $query = 'SELECT * FROM subjects ';
        $query .= 'ORDER BY position ASC';

        $subject_set = mysqli_query($db, $query);

        confirm_result_set($subject_set);

        return $subject_set;
    }

    function find_subject_by_id($id) {
        global $db;

        $query = "SELECT * FROM subjects WHERE id='$id'";

        $subject_set = mysqli_query($db, $query);

        confirm_result_set($subject_set);

        $subject = mysqli_fetch_assoc($subject_set);

        mysqli_free_result($subject_set);

        return $subject;
    }

    function insert_subject($subject) {
        $errors = validate_subject($subject);

        if (!empty($errors)) {
            return $errors;
        }

        global $db;

        $query = "INSERT INTO subjects
          (menu_name, position, visible)
          VALUES ('{$subject['menu_name']}', '{$subject['position']}', '{$subject['visible']}')";

        $result = mysqli_query($db, $query);

        if ($result) {
            return true;
        } else {
          echo mysqli_error($db);
          db_disconnect($db);
          exit;
        }
    }

    function update_subject($subject) {
        $errors = validate_subject($subject);

        if (!empty($errors)) {
            return $errors;
        }

        global $db;

        $query = "UPDATE subjects SET
        menu_name='{$subject['menu_name']}',
        position='{$subject['position']}',
        visible='{$subject['visible']}'
        WHERE id='{$subject['id']}' LIMIT 1";

        $result = mysqli_query($db, $query);

        if ($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_subject($id) {
        global $db;

        $query = "DELETE FROM subjects WHERE id='$id' LIMIT 1";

        $result = mysqli_query($db, $query);

        if ($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function get_subject_name_by_id($id) {
        global $db;

        $query = "SELECT menu_name FROM subjects WHERE id='$id' LIMIT 1";

        $menu_name_set = mysqli_query($db, $query);

        confirm_result_set($menu_name_set);

        $menu_name = mysqli_fetch_assoc($menu_name_set);

        mysqli_free_result($menu_name_set);

        return $menu_name['menu_name'];
    }

    function get_subject_names_and_ids() {
        global $db;

        $query = "SELECT id, menu_name FROM subjects";

        $menu_name_and_id_set = mysqli_query($db, $query);

        confirm_result_set($menu_name_and_id_set);

        $menu_name_and_id_list = [];

        while ($menu_name_and_id = mysqli_fetch_assoc($menu_name_and_id_set)) {
            array_push($menu_name_and_id_list, ['name' => $menu_name_and_id['menu_name'], 'id' => $menu_name_and_id['id']]);
        }

        mysqli_free_result($menu_name_and_id_set);

        return $menu_name_and_id_list;
    }

    function find_all_pages() {
        global $db;

        $query = 'SELECT * FROM pages ';
        $query .= 'ORDER BY subject_id ASC, position ASC';

        $page_set = mysqli_query($db, $query);

        confirm_result_set($page_set);

        return $page_set;
    }

    function find_page_by_id($id) {
        global $db;

        $query = "SELECT * FROM pages WHERE id='$id'";

        $page_set = mysqli_query($db, $query);

        confirm_result_set($page_set);

        $page = mysqli_fetch_assoc($page_set);

        mysqli_free_result($page_set);

        return $page;
    }

    function insert_page($page) {
        global $db;

        $query = "INSERT INTO pages
          (subject_id, menu_name, position, visible, content)
          VALUES ('{$page['subject_id']}', '{$page['menu_name']}', '{$page['position']}', '{$page['visible']}', '{$page['content']}')";

        $result = mysqli_query($db, $query);

        if ($result) {
            return true;
        } else {
          echo mysqli_error($db);
          db_disconnect($db);
          exit;
        }
    }

    function update_page($page) {
        global $db;

        $query = "UPDATE pages SET
        subject_id='{$page['subject_id']}',
        menu_name='{$page['menu_name']}',
        position='{$page['position']}',
        visible='{$page['visible']}',
        content='{$page['content']}'
        WHERE id='{$page['id']}' LIMIT 1";

        $result = mysqli_query($db, $query);

        if ($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_page($id) {
        global $db;

        $query = "DELETE FROM pages WHERE id='$id' LIMIT 1";

        $result = mysqli_query($db, $query);

        if ($result) {
            return true;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function count_pages_in_subjects() {
        global $db;

        $query = "SELECT subject_id, COUNT(*) AS count FROM pages GROUP BY subject_id";

        $count_set = mysqli_query($db, $query);

        confirm_result_set($count_set);

        $count_list = [];

        while ($count = mysqli_fetch_array($count_set)) {
            $count_list[$count['subject_id']] = $count['count'];
        }

        mysqli_free_result($count_set);

        return $count_list;
    }

?>
