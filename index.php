<?php

if ($_SERVER['REQUEST_URI'] == "/ping") {
  print("pong");
  exit;
}
//Codebase version
$version = 0.1;

//Check we can connect to the database
if (file_exists("settings/db.php")) {
  include("settings/db.php");
} else {
  print("<p>settings/db.php does not exist!</p>");
  print("<p>Refer to <a href='https://ontomasticon.github.io/installation.html'>Installation instructions.</a></p>");
  exit;
}

if ($_SERVER['REQUEST_URI'] == "/dbping" && $db->connect_error) {
  print("Database connection failed: ".$db->connect_error);
  exit;
}

require("core/core.php");

$GLOBALS["ontomasticon"]["config"] = getConfig($db);
$GLOBALS["ontomasticon"]["language"] = detectLanguage();
$GLOBALS["ontomasticon"]["cv_count"] = CVcount($db);
$GLOBALS["ontomasticon"]["CVs"] = getCVs($db);
$GLOBALS["ontomasticon"]["pageInfo"] = activePage();

switch($GLOBALS["ontomasticon"]["pageInfo"]["page_type"]) {
  case "api":
    template("api.php");
    break;
  default:
    template("core.php");
}
