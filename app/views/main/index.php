<p> Main </p>

<div>
<? foreach ($posts as $value): ?>
<div class="post">

    <p><? echo $value['login'] ?> || <? echo $value['mark'] ?> || <? echo $value['date'] ?></p>
    <img src="/public/materials/<?php echo $value['id']; ?>.jpg">
    <p><? echo htmlspecialchars($value['text']); ?></p>

</div>
<? endforeach; ?>
</div>
