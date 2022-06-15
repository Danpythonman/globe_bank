<?php

  require_once('../../../private/initialize.php');

  if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
  }

  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = [
      'id' => $id,
      'subject_id' => $_POST['subject_id'] ?? '',
      'menu_name' => $_POST['menu_name'] ?? '',
      'position' => $_POST['position'] ?? '',
      'visible' => $_POST['visible'] ?? '',
      'content' => $_POST['content'] ?? ''
    ];

    $result = update_page($page);

    redirect_to(url_for('/staff/pages/show.php?id=' . $page['id']));

  } else {
    $page = find_page_by_id($id);

    $subject_names_and_ids = get_subject_names_and_ids();

    $position_list = count_pages_in_subjects();
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
        <dt>Subject</dt>
        <dd>
          <select name="subject_id" id="subject-select">
            <?php
              foreach ($subject_names_and_ids as $subject_name_and_id) {
                echo "<option value=\"{$subject_name_and_id['id']}\"";

                if ($subject_name_and_id['id'] == $page['subject_id']) {
                  echo " selected";
                }

                echo ">{$subject_name_and_id['name']}</option>";
              }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position" id="position-select">
            <!-- Will be filled in with Javascript -->
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
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"><?php echo htmlspecialchars($page['content']) ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>
  </div>
</div>

<script>
  let currentSubjectId;

  <?php echo "currentSubjectId = {$page['subject_id']};" ?>

  let countsOfSubjectsPages = {};

  <?php foreach ($subject_names_and_ids as $subject_name_and_id) {
    $subject_id = $subject_name_and_id['id'];

    $count_for_subject = $position_list[$subject_id] ?? 0;

    echo "countsOfSubjectsPages[$subject_id] = $count_for_subject;"
  ?>
  <?php } ?>

  document.getElementById('subject-select').onchange = (event) => updatePositionDropdown(event.target);

  function updatePositionDropdown(subjectDropdown) {
    const subjectId = subjectDropdown.value;

    const subjectMaxPosition = currentSubjectId == subjectDropdown.value
      ? countsOfSubjectsPages[subjectId]
      : countsOfSubjectsPages[subjectId] + 1;

    const positionSelect = document.getElementById('position-select');

    positionSelect.innerHTML = "";

    for (let i = 1; i <= subjectMaxPosition; i++) {
      let option = document.createElement('option');

      option.value = i;
      option.innerHTML = i;

      positionSelect.appendChild(option);
    }
  }

  updatePositionDropdown(document.getElementById('subject-select'));
</script>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
