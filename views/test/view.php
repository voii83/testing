<?php include ROOT . '/template/header.php'; ?>
<h1>Тест - профессии “Повар”</h1>
<form action="/test/result" method="post">
    <input type="hidden" name="algorithm" value="cook">
    <?php foreach ($test as $key=>$question) : ?>
        <p><?= $key ?></p>
        <?php foreach ($question as $answer) : ?>
            <p>
                <input type="radio" name="<?= $answer['id_question'] ?>" value="<?= $answer['number_answer'] ?>">
                <?= $answer['answer'] ?>
            </p>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <button type="submit">Отправить</button>
</form>


<h1>Тест - профессии “Гурман”</h1>
<form action="/test/result" method="post">
    <input type="hidden" name="algorithm" value="gourmet">
    <?php foreach ($test as $key=>$question) : ?>
        <p><?= $key ?></p>
        <?php foreach ($question as $answer) : ?>
            <p>
                <input type="radio" name="<?= $answer['id_question'] ?>" value="<?= $answer['number_answer'] ?>">
                <?= $answer['answer'] ?>
            </p>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <button type="submit">Отправить</button>
</form>

<div class="main">
    <a href="/">К списку тестов</a>
</div>
<?php include ROOT . '/template/footer.php'; ?>