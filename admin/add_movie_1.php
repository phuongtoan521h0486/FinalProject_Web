<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Amount</title>
</head>
<body>
<form id="form" action="add_movie_2.php" method="POST">
    <label for="num_actors">Number of actors:</label>
    <input type='text' id='num_actors' name='num_actors'>
    <label for="num_genres">Number of genres:</label>
    <input type='text' id='num_genres' name='num_genres'>
    
    <button type="submit">Submit</button>
</form>
<a href="add.php">Back to add new actors or new genres</a>
</body>
</html>