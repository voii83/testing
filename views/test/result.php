<?php include ROOT . '/template/header.php'; ?>
<h1>Результат</h1>


<?php if ($result['error']) : ?>
<h2>Результат не посчитан</h2>
<?php else : ?>
    <p><?php Debug::dd($result) ?></p>
<?php endif; ?>
<div class="main">
    <a href="/">К списку тестов</a>
</div>

<?php include ROOT . '/template/footer.php'; ?>