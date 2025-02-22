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
        $ask = $_POST['ask'];
        $content = $_POST['content'];
        $heading = $_POST['heading'];

        $checkquery = "SELECT * FROM `home6` WHERE `Heading`='$heading' AND `Content`='$content' AND `Ask`='$ask'";
        $query = mysqli_query($con, $checkquery);
        $num_rows = mysqli_num_rows($query);
        if($num_rows > 0){ ?>
            <script>
                alert('Content already exists...');
            </script>
       <?php }
       else{          
            $insertquery = "INSERT INTO `home6` (`Heading`, `Content`, `Ask`, `Date`) VALUES ('$heading', '$content', '$ask', current_timestamp())";
            $query = mysqli_query($con, $insertquery);
            if($query){ ?>
                <script>
                    alert("Content has added successfully!");
                    location.replace('home_details.php');
                </script>
            <?php }
            else{ ?>
                <script>
                    alert("Something went wrong...");
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
    <title>Add Content</title>
    <link rel="icon" type="image/png" href="images/<?php echo $icon; ?>" />
    <link rel="stylesheet" href="footer_menu_add.css">
</head>
<body>
    <section id="container">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
                <h2>Add Content</h2>
                <div class="input">
                    <label for="heading">Heading</label>
                    <input type="text" id="heading" name="heading" autofocus autocomplete="off">
                </div>
                <div class="input">
                    <label for="content">Content</label>
                    <input type="text" id="content" name="content" autofocus autocomplete="off" required>
                </div>
                <div class="input">
                    <label for="ask">Ask</label>
                    <input type="text" id="ask" name="ask" autofocus autocomplete="off">
                </div>
                <div class="input" id="field-submit">
                    <button type="submit" name="submit" id="btn">Add Content</button>
                </div>
                <div class="input">
                    <button type="submit" id="btn1"><a href="home_details.php">Go Back</a></button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>