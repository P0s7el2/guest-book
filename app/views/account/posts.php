

<h3>Posts</h3>


<div>
    <ul>
        <? foreach ($posts as $value): ?>

            <li>

                <ul class="hr">
                    <li><img src="/public/materials/<?php echo $value['id']; ?>.jpg"></li>
                    <li><? echo $value['login']; ?></li>
                    <li><? echo $value['mark']; ?></li>
                    <li><? echo htmlspecialchars($value['text']); ?></li>
                    <li><? echo $value['date']; ?></li>
                    <li><a href="/account/delete/<? echo $value['id']; ?>">Delete</a></li>
                    <li><a href="/account/edit/<? echo $value['id']; ?>">Edit</a></li>
                </ul>
                <hr>
            </li>
        <? endforeach; ?>
    </ul>
</div>