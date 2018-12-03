<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?php echo $title; ?></title>

    <script src="/public/scripts/jquery-3.3.1.js"></script>
    <script src="/public/scripts/form.js"></script>
    <?php if ($this->route['action'] == 'index') : ?>
        <link rel="stylesheet" href="/public/styles/style.css">
    <?php endif; ?>
</head>

<body>
<p>
    <?php if (!$_SESSION['account']) : ?>
    <a href="/account/login">sign in</a> || <a href="/account/register">sign up</a>
    <?php elseif ($_SESSION['account']) : ?>
    <a href="/account/posts">posts</a>
    <?php endif; ?>
    <?php if ($_SESSION['admin']) : ?>
        || <a href="/admin">admin</a>
    <?php endif; ?>
    <?php echo $content; ?>

</p>
</body>
</html>