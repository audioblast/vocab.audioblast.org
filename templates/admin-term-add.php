<h2><?php print t("Terms"); ?></h2>

<?php
if (!userAllow("administer")) {
  print t("You do not have permission to administer this site");
} else {
  if(isset($_POST['submit'])){
    addTerm();
  }
  ?>
  <h3><?php print t("Add term"); ?></i></h3>
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <label for="shortname"><?php print t("Shortname"); ?></label><br/>
    <input type="text" id="shortname" name="shortname"
           placeholder="">
           <br/><br/>
    <label for="name"><?php print t("Name"); ?></label><br/>
    <input type="text" id="name" name="name"
           placeholder="">
           <br/><br/>
    <label for="description"><?php print t("Description"); ?></label><br/>
    <textarea id="description" name="description" rows="4" cols="50"></textarea><br/>
    <label for="language"><?php print t("Language"); ?></label><br/>
    <input type="text" id="language" name="language"
           placeholder="">
           <br/><br/>
    <label for="opaque"><?php print t("Opaque"); ?></label><br/>
    <input type="checkbox" id="opaque" name="opaque" value="opaque">
       <br/><br/>
    <label for="nocv"><?php print t("Controlled vocabulary"); ?></label><br/>
    <input type="radio" id="nocv" name="cv" value="none">
    <label for="nocv"><?php print t("None"); ?></label><br/>
    <?php foreach ($GLOBALS["ontomasticon"]["CVs"] as $CV) { ?>
      <input type="radio" id="<?php print $CV["shortname"]; ?>" name="cv"
        value="<?php print $CV["shortname"]; ?>">
      <label for="<?php print $CV["shortname"]; ?>"><?php print $CV["name"]; ?></label><br/>
    <?php }
    print "<br/"; ?>
    <label for="none"><?php print t("Invalidity"); ?></label><br/>
    <input type="radio" id="none" name="invalid" value="none">
    <label for="none"><?php print t("None"); ?></label><br>
    <input type="radio" id="synonym" name="invalid" value="Synonym">
    <label for="synonym"><?php print t("Synonym"); ?></label><br/><br/>
    <label for="parent"><?php print t("Parent"); ?></label><br/>
    <input type="text" id="parent" name="parent"
           placeholder="">
           <br/><br/>
    <label for="broader"><?php print t("Broader term"); ?></label><br/>
    <input type="text" id="broader" name="broader"
           placeholder="">
           <br/><br/>
    <button type="submit" name="submit"><?php print t("Save"); ?></button>
  </form>
<?php
}
end:
