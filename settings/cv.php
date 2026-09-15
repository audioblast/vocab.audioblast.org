<div class="feature-container">
<?php
if ($GLOBALS["ontomasticon"]["pageInfo"]["active_page"] == "") {
  //cv/ without a vocabulary name lists the vocabularies
  ?>
  <div class="feature">
  <?php
  if (count($GLOBALS["ontomasticon"]["CVs"]) > 0) {
    printCVs($GLOBALS["ontomasticon"]["CVs"]);
  } else {
    print t("There are no controlled vocabularies yet");
  }
  ?>
  </div>
  <?php
} else {
  $activeCV = null;
  foreach ($GLOBALS["ontomasticon"]["CVs"] as $CV) {
    if ($CV["shortname"] == $GLOBALS["ontomasticon"]["pageInfo"]["active_page"]) {
      $activeCV = $CV;
    }
  }
  ?>
  <div class="feature">
  <?php
  if ($activeCV == null) {
    print t("No matching controlled vocabulary found for")." ".h($GLOBALS["ontomasticon"]["pageInfo"]["active_page"]);
    //An old or mistyped link may be meant for one of the site's vocabularies
    if (count($GLOBALS["ontomasticon"]["CVs"]) > 0) {
      printCVs($GLOBALS["ontomasticon"]["CVs"]);
    }
  } else {
    ?>
    <h2><?php print t("Controlled Vocabulary").": ".h($activeCV["name"]); ?></h2>
    <div id="description"><?php print $activeCV["description"]; ?></div>
    <?php
  }
  ?>
  </div>
  <?php
  if ($activeCV != null) {
    ?>
    <div class="feature">
    <?php
    $terms = getTerms($activeCV["shortname"]);
    $oe = 1;
    foreach ($terms as $t) {
      $GLOBALS["ontomasticon"]["term"] = $t;
      $GLOBALS["ontomasticon"]["oddeven"] = oe($oe);
      template("term-fragment.php");
      $oe *= -1;
    }
    ?>
    </div>
    <?php
  }
}
?>
</div>
