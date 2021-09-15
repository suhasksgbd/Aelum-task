<?php
session_start();



include_once('./conn.php');

if (isset($_POST['submit'])) {


$name = mysqli_real_escape_string($db, $_POST['name']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$dob = mysqli_real_escape_string($db, $_POST['dob']);
$about = mysqli_real_escape_string($db, $_POST['about']);

if (isset($_POST['g-recaptcha-response'])){
    $recaptcha=$_POST['g-recaptcha-response'];
    
    if(!$recaptcha){
        echo '<script>alert("Please select the recaptcha properly")</script>';
        exit;
    }
else{
    $secret="6LemXmwcAAAAAB0tk67F24GM10cIJ4Qq3UXzkB8O";
    $url='https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$recaptcha;
    $response=file_get_contents($url);
    $responseKeys =json_decode($response,true);
    print_r($responseKeys);
}
}


$sql = "INSERT INTO data (name, email, dob, about) 
VALUES ('$name', '$email', '$dob', '$about')";
// execute query
$res = mysqli_query($db, $sql);

if ($res) {
    $msg = "Submitted";
    echo "<script type='text/javascript'>alert('$msg');window.location.href='index.php';</script>";
} else {
    $msg = "Failed to Submit";
    echo "<script type='text/javascript'>alert('$msg');window.location.href='index.php';</script>";
}
}

?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>task</title>
    <style>
        .myForm {
            font-size: 0.8em;
            width: 28em;
            padding: 1em;
            border: 1px solid #ccc;
            box-shadow: 5px 5px;
            margin-left: 500px;
            margin-top: 50px;
            background-color:transparent;
            align-items: center;
        }

        .myForm * {
            box-sizing: border-box;
        }

        .myForm fieldset {
            border: none;
            padding: 0;
        }

        .myForm legend,
        .myForm label {
            padding: 0;
            font-weight: bold;
        }

        .myForm label.choice {
            font-size: 0.9em;
            font-weight: normal;
        }

        .myForm input[type="text"],
        .myForm input[type="tel"],
        .myForm input[type="email"],
        .myForm input[type="date"],
        .myForm select,
        .myForm textarea {
            display: block;
            width: 100%;
            border: 1px solid #ccc;
            font-size: 0.9em;
            padding: 0.3em;
        }

        .myForm textarea {
            height: 100px;
        }

        .myForm button {
            padding: 1em;
            border-radius: 0.5em;
            background: #000;
            color: #ccc;
            border: none;
            font-weight: bold;
            margin-top: 1em;
            margin-left: -500px;
        }

        .myForm button:hover {
            background: #eee;
            color: #000;
            cursor: pointer;
        }
        #timer{
            align-items:center;
            margin-left: 1400px;
            font-size: 40px;
            color: red;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <span id="timer"></span>

<script>
var now = new Date();
var timeup = now.setSeconds(now.getSeconds() + 180);
//var timeup = now.setHours(now.getHours() + 1);

var counter = setInterval(timer, 1000);

function timer() {
  now = new Date();
  count = Math.round((timeup - now)/1000);
  if (now > timeup) {
      
    alert("Time Up Please Re-enter Again")
    window.location = "index.php"; //or somethin'
      clearInterval(counter);
      return;
  }
  var seconds = Math.floor((count%60));
  var minutes = Math.floor((count/60) % 60);
  document.getElementById("timer").innerHTML = minutes + ":" + seconds;
}
</script>
<!-- End of Timer -->
</head>

<body style="background-color: grey;" >
    <section>
        <div class="container">
            <div class="row">
                <form class="myForm" method="post">
                    <h2 style="text-align:center;">Form</h2>

                    <p>
                        <label>Name
                            <input type="text" name="name" id="name" style="width: 300px;" required>
                        </label>
                    </p>

                    <p>
                        <label>Email
                            <input type="email" name="email" id="email" style="width: 300px;" required>
                        </label>
                    </p>

                    <p>
                        <label>DOB
                            <input type="date" name="dob" id="dob" style="width: 300px;"  required>
                        </label>
                    </p>

                    <p>
                        <label>About yourself
                            <textarea name="about" id="about" style="width: 300px;" required></textarea>
                        </label>
                    </p>
                    <p>
                        <label>Captcha
                            <div class="g-recaptcha" data-sitekey="6LemXmwcAAAAACR5sikYwg4db1CcXH0mxgcpQfwR" style="width: 230px;"></div>
                            <br />
                            <input type="submit" value="Submit" name="submit" id="submit">
                        </label>
                    </p>
                </form>

            </div>
        </div>
    </section>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    -->    
</body>

</html>