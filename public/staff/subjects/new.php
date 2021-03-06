<?php

  require_once('../../../private/initialize.php');

  $menu_name = '';
  $position = '';
  $visible = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $subject = [
      'menu_name' => $_POST['menu_name'] ?? '',
      'position' => $_POST['position'] ?? '',
      'visible' => $_POST['visible'] ?? ''
    ];

    $result = insert_subject($subject);

    if ($result === true) {
      $result_id = mysqli_insert_id($db);
      redirect_to(url_for('/staff/subjects/show.php?id=' . $result_id));
    } else {
      $errors = $result;
    }
  }

  $subject_set = find_all_subjects();
  $subject_count = mysqli_num_rows($subject_set) + 1;
  mysqli_free_result($subject_set);

  $subject = ['position' => $subject_count];

?>

<?php $page_title = 'Create Subject'; ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
  <div class="subject new">
    <h1>Create Subject</h1>

    <?php
      if (isset($errors)) {
        echo display_errors($errors);
      }
    ?>

    <form action="<?php echo url_for('/staff/subjects/new.php'); ?>" method="post">
      <dl>
      <dt>Menu Name</dt>
        <dd>
          <input type="text" name="menu_name" value="<?php echo htmlspecialchars($menu_name) ?>" />
        </dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">

          <?php
              for ($i = 1; $i <= $subject_count; $i++) {
                echo "<option value=\"$i\"";
                if ($subject['position'] == $i) {
                  echo ' selected';
                }
                echo ">$i</option>";
              }
          ?>

          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" <?php echo $visible == '1' ? 'checked' : '' ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Subject" />
      </div>
    </form>
  </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
