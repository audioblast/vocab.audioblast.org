<?php session_start(); ?>
<!DOCTYPE html>
<html lang="<?php print t($GLOBALS["ontomasticon"]["config"]["default_lang"]); ?>">
<head>
<meta charset = "UTF-8">
<title><?php print tu("site_name"); ?></title>
<meta name="Generator" content="Ontomasticon (https://ontomasticon.github.io/)"/>
<meta name="author" content="<?php print($GLOBALS["ontomasticon"]["config"]["author"]); ?>">
<meta name="description" content="<?php print tu("description"); ?>">
<link rel="stylesheet" type="text/css" href="/css/default.css" />
<link rel="icon" type="image/png" href="/images/ontomasticon.png">
<?php
if (file_exists("settings/user.css")) {
  ?>
  <link rel="stylesheet" type="text/css" href="/settings/user.css" />
  <?php
}
?>

<body>
<div id="title" role="banner">
  <div style="width:100%; height:40px;">
    <a href="/">
    <img src="/images/ontomasticon.svg" id="logo" class="audioblast-flash"/>
    </a>
    <h1 id="site_title"><?php print tu("site_name"); ?></h1>
  </div>
  <div id="menu"><?php print tu("description"); ?></div>
  <?php
    if (userAllow("administer")) {
      $status = adminSanity();
      if ($status != NULL) {
        print '<div id="admin-warnings">';
        foreach($status as $key => $value) {
          print '<b>'.$key.'</b><p>'.$value.'</p><br>';
        }
        print '</div>';
      }
    }
  ?>
</div>



<?php
switch($GLOBALS["ontomasticon"]["pageInfo"]["page_type"]) {
  case "cv":
    template("cv.php");
    break;
  case "home":
    template("home.php");
    break;
  case "user":
    template("user.php");
    break;
  case "admin":
    template("admin.php");
    break;
  case "api":
    template("api-home.php");
    break;
}


?>

<div class="feature-container">

<div class="feature">
  <div id="citation">
  <p>To cite this website:</p>
  <?php printCitation(); ?>
  </div>
</div>

<div class="feature">
  <div id="footer">
  <?php printFooter(); ?>
  </div>
</div>

</div>

<div id="menubar">
<?php print adminLink(); ?><br/>
<?php print userLink(); ?><br/>
<?php print logInOut(); ?>
</body>

</html>
