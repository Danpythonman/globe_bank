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

    function find_all_pages() {
        global $db;

        $query = 'SELECT * FROM pages ';
        $query .= 'ORDER BY subject_id ASC, position ASC';

        $page_set = mysqli_query($db, $query);

        confirm_result_set($page_set);

        return $page_set;
    }

?>
