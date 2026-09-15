<?php
//The search box in the page header shows its results on the home page
if (searchPage()) {
  ?>
  <div class="feature-container">
  <div class="feature">
  <?php template("search.php"); ?>
  </div>
  </div>
  <?php
  return;
}

global $db;
if ($GLOBALS["ontomasticon"]["cv_count"] > 0) {
  ?>
  <div class="feature-container">
  <div class="feature">
  <?php
  printCVs(getCVs($db));
  ?>
  <br>
  </div>
  </div>
  <?php
}
?>
<div class="feature-container">
<div class="feature">
<h2>Terms</h2>
<?php
$GLOBALS["ontomasticon"]["terms"] = getTerms();
template("term-list.php");
?>
</div>
</div>
