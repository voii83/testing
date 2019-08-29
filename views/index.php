<?php include ROOT . '/template/header.php'; ?>
<h1>Информационная система тестирования.</h1>

<ul>
    <?php foreach ($testList as $test) : ?>
        <li>
            <div class="test-name"><?= $test['name'] ?></div>
            <a href="test/view/<?= $test['id'] ?>">Перейти к тестированию...</a>
        </li>
    <?php endforeach; ?>
</ul>
<?php include ROOT . '/template/footer.php'; ?>