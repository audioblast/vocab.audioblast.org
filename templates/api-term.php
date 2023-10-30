<?php
header('Content-Type: application/json; charset=utf-8');
global $db;
$config = getConfig($db);
if (isset($_GET["term"])) {
  $parts = explode("/", $_GET["term"]);
  if ($parts[3] == "cv") {
    $term = getTerm(explode("#",$parts[4])[1]);
  }
} else if (isset($_GET["shortname"])) {
  $term = getTerm($_GET["shortname"]);
} else if (isset($_GET["name"])) {
  $name = mysqli_real_escape_string($db, $_GET["name"]);
  $sql = "SELECT `shortname` FROM vocab.`terms` WHERE `name` = '$name'";
  $res = $db->query($sql);
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $term = getTerm($row["shortname"]);
  }
}

$term["url"] = term2URI($term);

print(($term == null) ? "null" : json_encode($term));
exit;