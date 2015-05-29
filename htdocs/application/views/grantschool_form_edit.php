<h2>Edit a Grant School</h2>

    <?php foreach ($school as $schoolinfo): ?>
    <p>Edit Detail & Click Update Button</p>
    <form method="post" action="<?php echo base_url() . "index.php/grantschool/update_site_id1"?>">

        <label id="hide">Id :</label>
        <input type="text" id="hide" name="did" value="<?php echo $schoolinfo->site_id; ?>">

        <label  for="text">School</label>
        <input type="text" name="dname" value="<?php echo $schoolinfo->site_number ?>"/>

        <label  for="text">Date Granted</label>
        <input type="text" name="ddate" value="<?php echo $schoolinfo->site_date_school ?>"/>

        <label  for="text">First Name</label>
        <input type="text" name="dfname" value="<?php echo $schoolinfo->fname ?>"/>

        <label  for="text">Last Name</label>
        <input type="text" name="dlname" value="<?php echo $schoolinfo->lname ?>"/>

        <label  for="text">Email</label>
        <input type="text" name="demail" value="<?php echo $schoolinfo->email ?>"/>

        <label  for="text">EID</label>
        <input type="text" name="deid" value="<?php echo $schoolinfo->eid ?>"/>

        <label  for="text">Phone number</label>
        <input type="text" name="dphone" name="dphone" value="<?php echo $schoolinfo->phone ?>"/><br>

        <input type="submit" id="submit" name="dsubmit" value="Update">
    </form>

    <?php endforeach; ?>