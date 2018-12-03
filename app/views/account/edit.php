<h3><?php echo $title; ?></h3>
<form action="/account/edit/<?php echo $data['id']; ?>" method="post">
    <p>mark 1/5</p>
    <p><input type="text" name="mark" value="<? echo htmlspecialchars($data['mark'], ENT_QUOTES); ?>"></p>
    <p>text</p>
    <p><input type="text" name="text" value="<? echo htmlspecialchars($data['text'], ENT_QUOTES); ?>"></p>
    <p>img</p>
    <p><input type="file" name="img"></p>
    <b><button type="submit" name="enter">Edit</button></b>
</form>