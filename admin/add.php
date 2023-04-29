<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add datato Database</title>
</head>
<body>
    <h1>Adding data <a href="add_movie_1.php">Go to add movie page</a></h1>
    <?php
        require_once('db_admin.php');
        $conn = connect();
    ?>
    <form action="add_actor.php" method="post" enctype="multipart/form-data">
        <label for="new_actor_name">Actor Name:</label>
        <input type="text" id="new_actor_name" name="new_actor_name">

        <label>Gender:</label>
        <label for="male">Male</label>
        <input type="radio" id="male" name="new_actor_gender" value=1>
        <label for="female">Female</label>
        <input type="radio" id="female" name="new_actor_gender" value=0>

        <label for="new_actor_dob">Date of birth:</label>
        <input type="date" id="new_actor_dob" name="new_actor_dob">

        <label for="new_actor_nationality">Nationality:</label>
        <input type="text" id="new_actor_nationality" name="new_actor_nationality">

        <label for="new_actor_bio">Bio:</label>
        <textarea id="new_actor_bio" name="new_actor_bio"></textarea>

        <label for="upload_director">Images:</label>
        <input type="file" name="fileupload_actor" id="fileupload_actor">
        <input type="submit" value="upload_actor" name="submit_actor">

    </form>   
    <h3>Last 5 actors</h3>
    <?php 
            $query ="SELECT person.*, idActor FROM person, actor WHERE person.idPerson = actor.idPerson ORDER BY person.idPerson DESC LIMIT 5";
            $result = $conn->query($query);
            if($result->num_rows> 0){
                while($data=$result->fetch_assoc()){
                    ?>
                        <p><?=$data['personName']?>,<?=$data['idPerson']?>,<?=$data['idActor']?></p>
                    <?php
                }
            }
    ?>
    

    <form action="add_director.php" method="post" enctype="multipart/form-data">
        <label for="new_director_name">Director Name:</label>
        <input type="text" id="new_director_name" name="new_director_name">

        <label>Gender:</label>
        <label for="male">Male</label>
        <input type="radio" id="male" name="new_director_gender" value=1>
        <label for="female">Female</label>
        <input type="radio" id="female" name="new_director_gender" value=0>

        <label for="new_director_dob">Date of birth:</label>
        <input type="date" id="new_director_dob" name="new_director_dob">

        <label for="new_director_nationality">Nationality:</label>
        <input type="text" id="new_director_nationality" name="new_director_nationality">

        <label for="new_director_bio">Bio:</label>
        <textarea id="new_director_bio" name="new_director_bio"></textarea>
        
        <label for="upload_director">Images:</label>
        <input type="file" name="fileupload_director" id="fileupload_director">
        <input type="submit" value="upload_director" name="submit_director">
    </form>   
    <h3>Last 5 directors</h3>
    <?php 
            $query ="SELECT person.*, idDirector FROM person, director WHERE person.idPerson = director.idPerson ORDER BY person.idPerson DESC LIMIT 5";
            $result = $conn->query($query);
            if($result->num_rows> 0){
                while($data=$result->fetch_assoc()){
                    ?>
                        <p><?=$data['personName']?>,<?=$data['idPerson']?>,<?=$data['idDirector']?></p>
                    <?php
                }
            }
    ?>

    <form action="add_studio.php" method="post">
        <label for="new_studio_name">Studio Name:</label>
        <input type="text" id="new_studio_name" name="new_studio_name">

        <label for="new_studio_location">Location:</label>
        <input type="text" id="new_studio_location" name="new_studio_location">

        <label for="new_studio_description">Description:</label>
        <textarea id="new_studio_description" name="new_studio_description"></textarea>

        
        <button type="submit">Add</button>
    </form>   
    <h3>Last 5 studios</h3>
    <?php 
            $query ="SELECT studioName FROM studio ORDER BY idStudio DESC LIMIT 5";
            $result = $conn->query($query);
            if($result->num_rows> 0){
                while($data=$result->fetch_assoc()){
                    ?>
                        <p><?=$data['studioName']?></p>
                    <?php
                }
            }
    ?>

<form action="add_genre.php" method="post">
        <label for="new_add_genre_name">Genre Name:</label>
        <input type="text" id="new_add_genre_name" name="new_add_genre_name">

        <label for="new_genre_description">Description:</label>
        <textarea id="new_genre_description" name="new_genre_description"></textarea>

        
        <button type="submit">Add</button>
    </form>   
    <h3>All genres</h3>
    <?php 
            $query ="SELECT genreName FROM genre ORDER BY idGenre DESC";
            $result = $conn->query($query);
            if($result->num_rows> 0){
                while($data=$result->fetch_assoc()){
                    ?>
                        <p><?=$data['genreName']?></p>
                    <?php
                }
            }
    ?>
    
</body>
</html>