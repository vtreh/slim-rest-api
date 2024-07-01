<?php if (isset($errors) && array_key_exists($field, $errors)) : ?>
    <?php foreach ($errors[$field] as $error) : ?>
        <p style="color:red;font-size:10px;"><?= $error ?></p>
    <?php endforeach; ?>
<?php endif; ?>