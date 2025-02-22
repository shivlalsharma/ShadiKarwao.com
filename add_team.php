<?php
    session_start();
    if(!isset($_SESSION['FullName'])){
        header('location:login_admin.php');
    }
    
    include 'connect.php';
    $icon = "";
    $selectquery = "SELECT * FROM `navbar4`";
    $query = mysqli_query($con, $selectquery);
    if($query){
        $fav_icon = mysqli_fetch_assoc($query); 
        $icon =  $fav_icon['Image'];
    } 

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $team_img = $_FILES['team_img']['name'];
        $team_tmp_name = $_FILES['team_img']['tmp_name'];
        $team_folder = "team_img/$team_img";

        $checkquery = "SELECT * FROM `teammngr03` WHERE `Person_Image`='$team_img'";
        $result = mysqli_query($con, $checkquery);
        $num_rows = mysqli_num_rows($result);
        if($num_rows > 0){ ?>
            <script>
                alert('Manager already exists...')
            </script>
       <?php }
        else{
            $insertquery = "INSERT INTO `teammngr03` (`Name`, `Person_Image`, `Date`) VALUES ('$name', '$team_img', current_timestamp())";
            $result  = mysqli_query($con, $insertquery);
            if($result){
                move_uploaded_file($team_tmp_name, $team_folder); ?>
                <script>
                    alert('Manager has added successfully!');
                    location.replace('team_details.php');
                </script>
           <?php }
            else{ ?>
                <script>
                    alert('Something went wrong...');
                </script>
           <?php }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team</title>
    <link rel="icon" type="image/png" href="images/<?php echo $icon; ?>" />
    <link rel="stylesheet" href="footer_menu_add.css">
</head>
<body>
    <section id="container">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <h2>Add Team</h2>
            <div class="input">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" autofocus autocomplete="off" required>
            </div>
            <div class="input">
                <label for="team_img">Manager</label>
                <input type="file" id="team_img" accept="image/*" name="team_img" autofocus autocomplete="off" required>
            </div>
            <div class="input" id="field-submit">
                <button type="submit" name="submit" id="btn">Add Manager</button>
            </div>
            <div class="input">
                <button type="submit" id="btn1"><a href="team_details.php">Go Back</a></button>
            </div>
        </form>
    </section>
</body>
</html>