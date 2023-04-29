<?php
    require_once("db_admin.php");
    $conn = connect();
    $num_actors = $_POST['num_actors'];
    $num_genres = $_POST['num_genres'];
?>
<html>
    <form action="add_movie_3.php" method="post" enctype="multipart/form-data">
        <h1>Enter Movie infomation</h1>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">
        <label for="releaseDate">Release Date:</label>
        <input type="date" id="releaseDate" name="releaseDate">
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <label for="runtime">Runtime:</label>
        <input type="text" id="runtime" name="runtime">
        <h1>Enter Trailer</h1>
        <label for="titleTrailer">Trailer name:</label>
        <input type="text" id="titleTrailer" name="titleTrailer">
        <label for="urlTrailer">url</label>
        <input type="text" id="urlTrailer" name="urlTrailer">

        <h1>Enter Studio</h1>
        <?php
            ?>
            <div id="availableStudio">
                <select class="studio_names" name="studio_names[]" multiple >
                <?php 
                    $query ="SELECT studioName, idStudio FROM studio";
                    $result = $conn->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['studioName'];
                        $idStudio = $optionData['idStudio'];
                    ?>
                        <option value="<?=$idStudio; ?>" selected><?=$option; ?></option>
                    <?php 
                        continue;
                    }
                ?>
                </select>
            </div>

            <?php
        }
        ?>

        <h1>Enter Actors</h1>
        <?php
        for ($i = 0; $i < $num_actors; ++$i) {
            ?>
            <p>Actor: <?= $i + 1 ?></p>
            <div id="availableActors">
                <select class="actor_names" name="actor_names[]" multiple >
                <?php 
                    $query ="SELECT personName, idActor FROM person, actor WHERE person.idPerson = actor.idPerson";
                    $result = $conn->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['personName'];
                        $idAdtor = $optionData['idActor'];
                    ?>
                        <option value="<?=$idAdtor; ?>" selected><?=$option; ?></option>
                    <?php 
                        continue;
                    }}
                ?>
                </select>
            </div>

            <?php
        }
        ?>
        <h1>Enter Directors</h1>
        <?php
            ?>
            <div id="availableDirectors">
                <select class="director_names" name="director_names[]" multiple >
                <?php 
                    $query ="SELECT personName, idDirector FROM person, director WHERE person.idPerson = director.idPerson";
                    $result = $conn->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['personName'];
                        $idDirector = $optionData['idDirector'];
                    ?>
                        <option value="<?=$idDirector; ?>" selected><?=$option; ?></option>
                    <?php 
                        continue;
                    }
                ?>
                </select>
            </div>

            <?php
        }
        ?>
        <h1>Enter Genres</h1>
        <?php
        for ($i = 0; $i < $num_genres; ++$i) {
            ?>
            <p>Genre: <?= $i + 1 ?></p>
            <div id="availableGenres">
                <select class="genre_names" name="genre_names[]" multiple >
                <?php 
                    $query ="SELECT genreName, idGenre FROM genre";
                    $result = $conn->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['genreName'];
                        $idGenre = $optionData['idGenre'];
                    ?>
                        <option value="<?=$idGenre; ?>" selected><?=$option; ?></option>
                    <?php 
                        continue;
                    }}
                ?>
                </select>
            </div>

            <?php
        }
        ?>
        <label for="upload_background">Background:</label>
        <input type="file" name="fileupload_background" id="fileupload_background">

        <label for="upload_poster">Poster:</label>
        <input type="file" name="fileupload_poster" id="fileupload_poster">

        <label for="upload_thumbnail">Thumbnail:</label>
        <input type="file" name="fileupload_thumbnail" id="fileupload_thumbnail">

        <input type="submit" value="upload" name="submit">
    </form>
</html>
