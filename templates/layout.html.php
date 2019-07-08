<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="jokes.css">
    <link rel="stylesheet" href="form.css">
    <title><?=$title?></title>
  </head>
  <body>

  <header>
    <h1>Internet Joke Database</h1>
  </header>

  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="jokes.php">Jokes List</a></li>
      <li><a href="editjoke.php">Add a New Joke</a></li>
    </ul>
  </nav>

  <main>
  <?=$output?>
  </main>

  <footer>
  &copy; IJDB 2019
  </footer>

  </body>
</html>