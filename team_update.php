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
        $id = $_POST['Sr_No'];
        $name = $_POST['name'];
        $team_img = $_FILES['team_img']['name'];
        $team_tmp_name = $_FILES['team_img']['tmp_name'];
        $team_folder = "team_img/$team_img";

        $checkquery = "SELECT * FROM `teammngr03` WHERE `Person_Image`='$team_img' && `Name`='$name'";
        $result = mysqli_query($con, $checkquery);
        $num_rows = mysqli_num_rows($result);
        if($num_rows > 0){ ?>
            <script>
                alert('Manager already exists...');
                location.replace('team_details.php');
            </script>
       <?php }
        else{
            $updatequery = "UPDATE `teammngr03` SET `Name`='$name', `Person_Image`='$team_img', `Date`=current_timestamp() WHERE `Sr_No`=$id";
                $result = mysqli_query($con, $updatequery);
                if($result){
                    move_uploaded_file($team_tmp_name, $team_folder); ?>
                    <script>
                        alert('Manager has updated successfully!');
                        location.replace('team_details.php');
                    </script>
            <?php }
                else{ ?>
                    <script>
                        alert('Something went wrong...');
                        location.replace('team_details.php');
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
    <title>Update Team</title>
    <link rel="icon" type="image/png" href="images/<?php echo $icon; ?>" />
    <link rel="stylesheet" href="footer_menu_add.css">
</head>
<body>
    <?php
        $id = $_GET['update'];
        $selectquery = "SELECT * FROM `teammngr03` WHERE `Sr_No`=$id";
        $result = mysqli_query($con, $selectquery);
        if($result){
            while($row = mysqli_fetch_assoc($result)){  
    ?>
    <section id="container">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <h2>Update Team</h2>
                <div class="input">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['Name']; ?>" autofocus autocomplete="off" required>
                </div>
                <div class="input">
                    <label for="team_img">Manager</label>
                    <input type="file" id="team_img" accept="image/*" name="team_img" autofocus autocomplete="off" required>
                    <img src="team_img/<?php echo $row['Person_Image']; ?>" alt="Team Image" width="120" height="120">
                </div>
                <input type="hidden" name="Sr_No" value="<?php echo $row['Sr_No']; ?>">
                <div class="input" id="field-submit">
                    <button type="submit" name="submit" id="btn">Update Manager</button>
                </div>
                <div class="input">
                    <button type="submit" id="btn1"><a href="team_details.php">Go Back</a></button>
                </div>
            </form>
        </section>
        <?php }
        } ?>
</body>
</html>