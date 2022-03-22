<?php

// foreach($_POST as $key => $value) {
//     $contact[$key] = trim($value);
// }

$errors = [];
$countries = [
    'france' => 'France',
    'italy' => 'Italie',
    'ukraine' => 'Ukraine',
    'spain' => 'Espagne',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contact = array_map('trim', $_POST);

    if (empty($contact['firstname'])) {
        $errors[] = 'Le prénom est obligatoire';
    }

    $firstnameMaxLength = 70;
    if (strlen($contact['firstname']) > $firstnameMaxLength) {
        $errors[] = 'Le prénom doit faire moins de ' . $firstnameMaxLength . ' caractères';
    }

    if (empty($contact['email'])) {
        $errors[] = 'L\'email est obligatoire';
    }

    $emailMaxLength = 255;
    if (strlen($contact['email']) > $emailMaxLength) {
        $errors[] = 'Le mail doit faire moins de ' . $emailMaxLength . ' caractères';
    }

    if (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Mauvais format pour l\'email ' . htmlentities($contact['email']);
    }

    if (empty($contact['message'])) {
        $errors[] = 'Le message est obligatoire';
    }

    if (!key_exists($contact['country'], $countries)) {
        $errors[] = 'Le pays est invalide';
    }

    if (empty($errors)) {
        // traitement de mon form
        // insert en bdd
        // envoie de mail...

        header('Location: /index.php'); // redirection en GET (vide le POST)
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livecoding form</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <h1>Contact</h1>
        <form action="" method="POST" novalidate>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" name="firstname" placeholder="John Doe" required value="<?= $contact['firstname'] ?? '' ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= $contact['email']  ?? '' ?>" placeholder="john@doe.com" required>

            <label for="country">Pays</label>
            <select name="country" id="country">
                <?php foreach ($countries as $countryCode => $country) : ?>
                    <option value="<?= $countryCode ?>" 
                        <?= isset($contact['country']) && $contact['country'] === $countryCode ? 'selected' : '' ?>
                    >
                        <?= $country ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="message">Message</label>
            <textarea name="message" id="message" cols="30" rows="10" required><?= $contact['message'] ?? '' ?></textarea>
            <div>max 3000 caractères</div>
            <button>Envoyer</button>
        </form>
    </main>

</body>

</html>