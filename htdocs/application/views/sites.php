<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <site_number>ESE Grant</site_number>
</head>
<body>
<h1>ESE Grant</h1>
<div>
    Found <?php echo $num_results; ?> Sites
</div>
<table>
    <thead>
        <th>Site ID</th>
        <th>Site</th>
        <th>Grant Approved</th>
        <th>First Name</th>
        <th>Last name</th>
        <th>EID</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
    </thead>

    <tbody>
        <?php foreach ($grants as $grant): ?>
        <tr>
            <td><?php echo $grant->site_id; ?></td>
            <td><?php echo $grant->site_number; ?></td>
            <td><?php echo $grant->site_date_school; ?></td>
            <td><?php echo $grant->fname; ?></td>
            <td><?php echo $grant->lname; ?></td>
            <td><?php echo $grant->eid; ?></td>
            <td><?php echo $grant->email; ?></td>
            <td><?php echo $grant->phone; ?></td>
            <td><?php echo anchor ('grantschool/view/' . $grant->site_id, '<img src="/img/view.png" >') . ' | ' .
                           anchor ('grantschool/show_site_id/' . $grant->site_id, '<img src="/img/edit.png" >') . ' | ' .
                           anchor ('grantschool/delete/' . $grant->site_id, '<img src="/img/delete.png" >')?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <div>
            Pages: <?php echo $pagination ?>
        </div>


</body>
</html>
