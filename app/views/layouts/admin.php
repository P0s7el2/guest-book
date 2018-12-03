<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?php echo $title; ?></title>


    <link rel="stylesheet" href="/public/styles/admin.css">


    <script src="/public/scripts/jquery-3.3.1.js"></script>
    <script src="/public/scripts/form.js"></script>
</head>

<body>

<h2> Admin page </h2>
<?php if ($this->route['action'] != 'login') : ?>
<p><a href="/admin/logout">Exit</a> <a href="/">Main</a></p>
<?php endif; ?>
    <?php echo $content; ?>

</body>
</html>