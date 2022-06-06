<?php

  require_once('../../../private/initialize.php');

  if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
  }

  $id = $_GET['id'];

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

    $result = update_page($page);

    redirect_to(url_for('/staff/pages/show.php?id=' . $page['id']));

  } else {
    $page = find_page_by_id($id);
  }

?>

<?php $page_title = 'Edit Page'; ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>
  <div class="page edit">
    <h1>Edit Page</h1>
    <form action="<?php echo url_for('/staff/pages/edit.php?id=' . htmlspecialchars(urlencode($id))); ?>" method="post">
      <dl>
      <dt>Menu Name</dt>
        <dd>
          <input type="text" name="menu_name" value="<?php echo htmlspecialchars($page['menu_name']) ?>" />
        </dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <option value="1" <?php echo $page['position'] == '1' ? 'selected' : '' ?>>1</option>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" <?php echo $page['visible'] == '1' ? 'checked' : '' ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>
  </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
