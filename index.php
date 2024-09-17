<?php
$errors = [
    'Поле пустое', //0 
    'Поле должно содержать минимум 3 символа', //1
    'Почта должна состоять минимум из 5 символов', //2
    'Почта должна быть корректна', //3
    'Номер телефона должен содержать минимум 7 символов' //4
];

$errorsList = []; 

// Функция проверки полей и добавления ошибок
function validateField($value, $minLength, $errorIndex, &$errorsList) {
    global $errors;
    if (empty($value)) {
        $errorsList[] = $errors[0];
    } elseif (strlen($value) < $minLength) {
        $errorsList[] = $errors[$errorIndex];
    }
}

// Функция проверки email и телефона
function validateEmail($email, &$errorsList) {
    global $errors;
    if (empty($email)) {
        $errorsList[] = $errors[0];
    } elseif (strlen($email) < 5 || strlen($email) > 30) {
        $errorsList[] = $errors[2];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorsList[] = $errors[3];
    }
}

function validatePhone($phone, &$errorsList) {
    global $errors;
    if (empty($phone)) {
        $errorsList[] = $errors[0];
    } elseif (strlen($phone) < 7) {
        $errorsList[] = $errors[4];
    }
}

if (isset($_POST['push'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    validateField($name, 3, 1, $errorsList);
    validateEmail($email, $errorsList);
    validatePhone($phone, $errorsList);

    if (empty($errorsList)) {
        echo 'Успешная регистрация';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" method="post">
        <label for="name">Имя*</label>
        <input type="text" name="name" placeholder="Имя пользователя" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <?php if (isset($_POST['push'])): ?>
            <?php if (in_array($errors[0], $errorsList)): ?>
                <p><?= $errors[0] ?></p>
            <?php elseif (in_array($errors[1], $errorsList)): ?>
                <p><?= $errors[1] ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <label for="email">Email*</label>
        <input type="text" name="email" placeholder="Ваша почта" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <?php if (isset($_POST['push'])): ?>
            <?php if (in_array($errors[0], $errorsList)): ?>
                <p><?= $errors[0] ?></p>
            <?php elseif (in_array($errors[2], $errorsList)): ?>
                <p><?= $errors[2] ?></p>
            <?php elseif (in_array($errors[3], $errorsList)): ?>
                <p><?= $errors[3] ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <label for="phone">Номер телефона*</label>
        <input type="text" name="phone" placeholder="+7 -___--__" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
        <?php if (isset($_POST['push'])): ?>
            <?php if (in_array($errors[0], $errorsList)): ?>
                <p><?= $errors[0] ?></p>
            <?php elseif (in_array($errors[4], $errorsList)): ?>
                <p><?= $errors[4] ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <button type="submit" name="push">Отправить данные</button>
    </form>

    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 10px;
        }
        p {
            color: red;
        }
    </style>
</body>
</html>
