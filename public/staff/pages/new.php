<?php

  require_once('../../../private/initialize.php');

  $menu_name = '';
  $position = '';
  $visible = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = [
      'id' => $id,
      'subject_id' => 1,
      'menu_name' => $_POST['menu_name'] ?? '',
      'position' => $_POST['position'] ?? '',
      'visible' => $_POST['visible'] ?? '',
      'content' => $_POST['content'] ?? ''
    ];

    insert_page($page);

    $result_id = mysqli_insert_id($db);

    redirect_to(url_for('/staff/pages/show.php?id=' . $result_id));
  } else {
    $page = [];
  }

?>

<?php $page_title = 'Create Page'; ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>
  <div class="page new">
    <h1>Create Page</h1>
    <form action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">
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
            <option value="1" <?php echo $position == '1' ? 'selected' : '' ?>>1</option>
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
        <input type="submit" value="Create Page" />
      </div>
    </form>
  </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
