
<?php 
    session_start();
    if(isset($_SESSION['login']))
    {
      header ("Location: index.php");
    } 
    else if(isset($_POST['submit']))
    {
      if($_POST['username']=='admin' && $_POST['password']=='admin@123')
      {
        $_SESSION['login']=true;
        header("Location: index.php");
      }
      else
      {
        echo "<script>alert('Invalid Credentials..');</script>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Apartment Admin Panel</title>
  </head>
  <body>
  <header>
    <style>
      #intro {
        background-image: url(https://mdbootstrap.com/img/new/fluid/city/008.jpg);
        height: 100vh;
      }
    </style>

    <!-- Background image -->
    <div id="intro" class="bg-image shadow-2-strong">
      <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-md-8">
              <form class="bg-white rounded shadow-5-strong p-5" method="post" method="#">
                  <h4 class="mb-4">Login Page</h4>
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="text" id="form1Example1" class="form-control" name="username" required/>
                  <label class="form-label" for="form1Example1">User Name</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                  <input type="password" id="form1Example2" class="form-control" name="password" required/>
                  <label class="form-label" for="form1Example2">Password</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block" name="submit">Sign in</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>