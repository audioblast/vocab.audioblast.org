<?php
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
$terms = getTerms();
$oe = 1;
foreach ($terms as $term) {
  $GLOBALS["ontomasticon"]["term"] = $term;
  $GLOBALS["ontomasticon"]["oddeven"] = oe($oe);
  template("term-fragment.php");
  $oe *= -1;
}
?>
</div>
</div>