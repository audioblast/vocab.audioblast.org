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

if (count($GLOBALS["ontomasticon"]["CVs"]) > 0) {
  ?>
  <div class="feature-container">
  <div class="feature">
  <?php
  printCVs($GLOBALS["ontomasticon"]["CVs"]);
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
$GLOBALS["ontomasticon"]["terms"] = validTerms(currentPageTerms());
template("term-list.php");
?>
</div>
</div>
