<?php
// Ontomasticon: a simple, lightweight, PHP-based ontology browser.
// Department of Information Retrieval
//
// Code to handle retreiving, editing and saving terms

function getTerm($shortname) {
  global $db;
  $sql = "SELECT * FROM `terms` WHERE `shortname` = '".$shortname."';";
  $result = $db->query($sql);
  if ($result) {
    $ret = $result->fetch_assoc();
    if ($result->num_rows == 0) {return(null);}
    $result->close();
    if ($ret["parent"] != "") {
      $sql = "SELECT `shortname` FROM `terms` WHERE `id` = ".$ret["parent"].";";
      $res = $db->query($sql);
      $ret["parent"] = $res->fetch_assoc()["shortname"];
      $res->close();
    }
    if ($ret["broader"] != "") {
      $sql = "SELECT `shortname` FROM `terms` WHERE `id` = ".$ret["broader"].";";
      $res = $db->query($sql);
      $ret["broader"] = $res->fetch_assoc()["shortname"];
      $res->close();
    }
    return($ret);
  } else {
    return(null);
  }
}

function getTerms($cv=null) {
  global $db;
  if ($cv != null) {
    $sql  = "SELECT * FROM `terms` WHERE `cv` = '";
    $sql .= $db->real_escape_string($cv);
    $sql .= "' AND `invalid_reason` IS NULL ORDER BY `shortname`;";
  }  else {
    $sql  = "SELECT * FROM `terms` WHERE `cv` IS NULL AND `invalid_reason` IS NULL;";
  }

  $result = $db->query($sql);
  if ($result) {
    $ret = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
  }

  //Need to add child terms
  $out = array();
  foreach ($ret as $row) {
    $sql = "SELECT * FROM `terms` WHERE `parent` = ".$row["id"]." ORDER BY `invalid_reason`;";
    $result = $db->query($sql);
    if ($result) {
      $row["children"] = $result->fetch_all(MYSQLI_ASSOC);
      $result->close();
    }
    $sql = "SELECT * FROM `terms` WHERE `broader` = ".$row["id"]." AND `invalid_reason` IS NULL ORDER BY `shortname`;";
    $result = $db->query($sql);
    if ($result) {
      $row["narrower"] = $result->fetch_all(MYSQLI_ASSOC);
      $result->close();
    }
    if ($row["broader"] != "") {
      $sql = "SELECT * FROM `terms` WHERE `id` = ".$row["broader"]." AND `invalid_reason` IS NULL;";
      $result = $db->query($sql);
      if ($result) {
        $row["broader"] = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
      }
    }
  $out[] = $row;
  }
  return($out);
}

function term2URI($term, $link=FALSE) {
  global $db;
  $config = getConfig($db);
  $out = "https://".$config["base_url"];
  if ($term['cv'] == null) {
    if ($term["opaque"] == 0) {
      $out .= $term["shortname"];
    } else {
      $out .= $term["id"];
    }
  } else {
    if ($term["opaque"] == 0 ) {
      $out .= "cv/".$term["cv"]."#".$term["shortname"];
    } else {
      $out .= "cv/".$term["cv"]."#".$term["id"];
    }
  }
  return(($link) ? l($out, $out) : $out);
}

function editTerm() {
  global $db;
  $shortname = $GLOBALS["ontomasticon"]["pageInfo"]["active_subsubpage"];
  $name = $db->real_escape_string(trim($_POST['name']));
  $description = $db->real_escape_string(trim($_POST['description']));
  $language = $db->real_escape_string(trim($_POST['language']));
  $opaque = (isset($_POST["opaque"]) ? 1 : 0);
  $cv = ((!isset($_POST["cv"]) || $_POST["cv"]=="none") ? "" : $db->real_escape_string(trim($_POST['cv'])));
  $invalid = ((!isset($_POST["invalid"]) || $_POST["invalid"]=="none") ? "" : $db->real_escape_string(trim($_POST['invalid'])));
  $parent = $db->real_escape_string(trim($_POST['parent']));
  $broader = $db->real_escape_string(trim($_POST['broader']));
  $reference = $db->real_escape_string(trim($_POST['reference']));

  $sql  = "UPDATE `terms` SET ";
  $sql .= "`name` = '".$name."', ";
  $sql .= "`description` = '".$description."', ";
  $sql .= "`language` = '".$language."', ";
  $sql .= "`opaque` = '".$opaque."', ";
  if ($invalid == "") {
    $sql .= "`invalid_reason` = NULL, ";
  } else {
    $sql .= "`invalid_reason` = '".$invalid."', ";
  }
  if ($cv == "") {
    $sql .= "`cv` = NULL, ";
  } else {
    $sql .= "`cv` = '".$cv."', ";
  }
  if ($_POST["parent"] != "") {
    $sql2 = "SELECT id FROM terms WHERE shortname = '".$parent."';";
    $res2 = $db->query($sql2);
    $sql .= "`parent` = ".$res2->fetch_assoc()["id"].", ";
  } else {
    $sql .= "`parent` = NULL, ";
  }
  if ($_POST["broader"] != "") {
    $sql2 = "SELECT id FROM terms WHERE shortname = '".$broader."';";
    $res2 = $db->query($sql2);
    $sql .= "`broader` = ".$res2->fetch_assoc()["id"].", ";
  } else {
    $sql .= "`broader` = NULL, ";
  }
  $sql .= "`reference` = '".$reference."' ";
  $sql .= "WHERE `shortname` = '".$shortname."';";
  $res = $db->query($sql);
}

function addTerm() {
  global $db;
  $shortname = $db->real_escape_string(trim($_POST['shortname']));
  $name = $db->real_escape_string(trim($_POST['name']));
  $description = $db->real_escape_string(trim($_POST['description']));
  $language = $db->real_escape_string(trim($_POST['language']));
  $opaque = (isset($_POST["opaque"]) ? 1 : 0);
  $cv = ((!isset($_POST["cv"]) || $_POST["cv"]=="none") ? "" : $db->real_escape_string(trim($_POST['cv'])));
  $invalid = ((!isset($_POST["invalid"]) || $_POST["invalid"]=="none") ? "" : $db->real_escape_string(trim($_POST['invalid'])));
  $parent = $db->real_escape_string(trim($_POST['parent']));
  $broader = $db->real_escape_string(trim($_POST['broader']));

  $sql  = "INSERT INTO `terms` (`shortname`, `name`, `description`, `language`, `opaque`, `invalid_reason`, `cv`, `parent`, `broader`) VALUES ( ";
  $sql .= "'".$shortname."', ";
  $sql .= "'".$name."', ";
  $sql .= "'".$description."', ";
  $sql .= "'".$language."', ";
  $sql .= "'".$opaque."', ";
  if ($invalid == "") {
    $sql .= "NULL, ";
  } else {
    $sql .= "'".$invalid."', ";
  }
  if ($cv == "") {
    $sql .= "NULL, ";
  } else {
    $sql .= "'".$cv."', ";
  }
  if ($_POST["parent"] != "") {
    $sql2 = "SELECT id FROM terms WHERE shortname = '".$_POST["parent"]."';";
    $res2 = $db->query($sql2);
    $sql .= $res2->fetch_assoc()["id"].", ";
  } else {
    $sql .= "NULL, ";
  }
  if ($_POST["broader"] != "") {
    $sql2 = "SELECT id FROM terms WHERE shortname = '".$_POST["broader"]."';";
    $res2 = $db->query($sql2);
    $sql .= $res2->fetch_assoc()["id"];
  } else {
    $sql .= "NULL";
  }
  $sql .= ");";
  $res = $db->query($sql);
}

function deleteTerm() {
  global $db;
  $sn = $GLOBALS["ontomasticon"]["pageInfo"]["active_subsubpage"];

  $sql = "DELETE FROM `terms` WHERE `shortname` = '".$sn."';";
  $res = $db->query($sql);
}
