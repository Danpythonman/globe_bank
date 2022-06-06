<?php

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

?>
