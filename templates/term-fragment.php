<div class="term <?php print $GLOBALS["ontomasticon"]["oddeven"]; ?>" id ="<?php print $GLOBALS["ontomasticon"]["term"]["shortname"]; ?>">
  <h3><?php
    print $GLOBALS["ontomasticon"]["term"]["name"];
    print " ";
    print termEditLink($GLOBALS["ontomasticon"]["term"]["shortname"]);
  ?></h3>
  <p><?php print term2URI($GLOBALS["ontomasticon"]["term"], TRUE); ?></p>
  <p><?php print $GLOBALS["ontomasticon"]["term"]["language"]; ?></p>
  <p><?php print $GLOBALS["ontomasticon"]["term"]["description"]; ?></p>
  <?php
  template("term-fragment-reference.php");

  if (is_array($GLOBALS["ontomasticon"]["term"]["children"]) && count($GLOBALS["ontomasticon"]["term"]["children"]) > 0) {
  ?>
    <h4><?php print t("Related terms"); ?></h4>
    <table>
    <?php
    foreach ($GLOBALS["ontomasticon"]["term"]["children"] as $child) {
      print "<tr>";
      print "<td class='invalid_reason'>".t($child["invalid_reason"])."</td>";
      print "<td class='child_term_name'><a href='".term2URI($child)."'>".$child["name"]."</a></td>";
      print "<td class='child_term_language'>".$child["language"]."</td>";
      print "<td class='child_term_editlink'>".termEditLink($child["shortname"])."</td>";
      print "</tr>";
    }
    ?>
    </table>
  <?php
  }
  ?>

  <?php
  if (is_array($GLOBALS["ontomasticon"]["term"]["broader"]) && count($GLOBALS["ontomasticon"]["term"]["broader"]) > 0) {
    ?>
    <h4><?php print t("Broader term"); ?></h4>
    <table>
    <?php
    foreach ($GLOBALS["ontomasticon"]["term"]["broader"] as $child) {
      print "<tr>";
      print "<td class='invalid_reason'>".$child["invalid_reason"]."</td>";
      print "<td class='child_term_name'><a href='".term2URI($child)."'>".$child["name"]."</a></td>";
      print "<td class='child_term_language'>".$child["language"]."</td>";
      print "<td class='child_term_editlink'>".termEditLink($child["shortname"])."</td>";
      print "</tr>";
    }
    ?>
    </table>
  <?php
  }
  ?>

  <?php
  if (is_array($GLOBALS["ontomasticon"]["term"]["narrower"]) && count($GLOBALS["ontomasticon"]["term"]["narrower"]) > 0) {
    ?>
    <h4><?php print t("Narrower terms"); ?></h4>
    <table>
    <?php
    foreach ($GLOBALS["ontomasticon"]["term"]["narrower"] as $child) {
      print "<tr>";
      print "<td class='invalid_reason'>".$child["invalid_reason"]."</td>";
      print "<td class='child_term_name'><a href='".term2URI($child)."'>".$child["name"]."</a></td>";
      print "<td class='child_term_language'>".$child["language"]."</td>";
      print "<td class='child_term_editlink'>".termEditLink($child["shortname"])."</td>";
      print "</tr>";
    }
    ?>
    </table>
  <?php
  }
  ?>
</div>
