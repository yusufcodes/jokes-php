<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jokes</title>
</head>
<body>
<p><?=$totalJokes?> jokes have been submitted to the Internet Joke Database.</p>
    <?php if (isset($output)): ?>
    <p>
        <?php echo $output; ?>
    </p>

    <?php else: ?>
    <h2>Jokes</h2>
    <?php foreach($jokes as $joke): ?>
    <blockquote>
        <p>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8'); ?>
        <a href=""></a>
        (by
        <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES,
        'UTF-8'); ?>"><?php echo htmlspecialchars($joke['name'], ENT_QUOTES,'UTF-8'); ?></a>
        on
        <?php
        $date = new DateTime($joke['jokedate']);
        echo $date->format('jS F Y');
        ?>)</p>

        <a href="editjoke.php?id=<?=$joke['id']?>">Edit</a>
        
        <form action="deletejoke.php" method="post">
            <input type="hidden" name="id" value="<?=$joke['id']?>">
            <input type="submit" value="Delete">
        </form>
    </blockquote>
    <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>