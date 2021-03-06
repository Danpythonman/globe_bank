<?php require_once('../../../private/initialize.php'); ?>

<?php
  $id = htmlspecialchars($_GET['id'] ?? '1');

  $page = find_page_by_id($id);
?>

<?php $page_title = 'Show Page' ?>

<?php include(SHARED_PATH . '/staff_header.php') ?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('staff/pages/index.php'); ?>">&laquo; Back to Page List</a>
  <div class="page show">
    <h1>Page: <?php echo htmlspecialchars($page['menu_name']); ?></h1>
    <div class="attributes">
      <dl>
        <dt>Menu Name</dt>
        <dd><?php echo htmlspecialchars($page['menu_name']); ?></dd>
      </dl>
      <dl>
        <dt>Subject Name</dt>
        <dd><?php echo htmlspecialchars(get_subject_name_by_id($page['subject_id'])); ?></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd><?php echo htmlspecialchars($page['position']); ?></dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd><?php echo $page['visible'] == '1' ? 'true' : 'false'; ?></dd>
      </dl>
    </div>
  </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php') ?>
