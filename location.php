<html>
  <head>
  <meta charset="utf-8">
    <title>Travel Information</title>
  <link rel="stylesheet" type="text/css" href="location.css">
  </head>
    <header> 
        <h1>Tour Guide Portal</h1>
        <nav class="navbar">
          <ul>
            <li>
              <a  class="nav-link" href="index.html">Home</a>
            </li>
            <li>
            <a class="nav-link" id="logout-link">Logout</a>
            </li>
          </ul>
        </nav>
      </header>
      <script>
  document.getElementById("logout-link").addEventListener("click", function(event) {
    event.preventDefault();
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = "index.html";
      window.history.replaceState(null, null, "index.html");
    }
  });
</script>
      <body>
    <h2>Select Starting Place and Ending Place:</h2>
    <form action="" method="post">
    <select name="starting_place">
        <option value="Tamil Nadu" <?php if(isset($_POST['starting_place']) && $_POST['starting_place'] == 'Tamil Nadu') echo 'selected'; ?>>Tamil Nadu</option>
        <option value="Kerala" <?php if(isset($_POST['starting_place']) && $_POST['starting_place'] == 'Kerala') echo 'selected'; ?>>Kerala</option>
        <option value="Maharashtra" <?php if(isset($_POST['starting_place']) && $_POST['starting_place'] == 'Maharashtra') echo 'selected'; ?>>Maharashtra</option>
        <option value="Goa" <?php if(isset($_POST['starting_place']) && $_POST['starting_place'] == 'Goa') echo 'selected'; ?>>Goa</option>
      </select>
      <select name="ending_place">
  <option value="Delhi" <?php if(isset($_POST['ending_place']) && $_POST['ending_place'] == 'Delhi') echo 'selected'; ?>>Delhi</option>
  <option value="Uttar Pradesh" <?php if(isset($_POST['ending_place']) && $_POST['ending_place'] == 'Uttar Pradesh') echo 'selected'; ?>>Uttar Pradesh</option>
  <option value="Rajasthan" <?php if(isset($_POST['ending_place']) && $_POST['ending_place'] == 'Rajasthan') echo 'selected'; ?>>Rajasthan</option>
  <option value="Punjab" <?php if(isset($_POST['ending_place']) && $_POST['ending_place'] == 'Punjab') echo 'selected'; ?>>Punjab</option>
</select>

      <input type="submit" name="submit" value="Submit">
    </form>

    <?php
      if (isset($_POST['submit'])) {
        $starting_place = $_POST['starting_place'];
        $ending_place = $_POST['ending_place'];

        $conn = mysqli_connect("localhost", "root", "", "places_db");
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM places WHERE starting_place = '$starting_place' and ending_place = '$ending_place'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
     ?>

<div class="container" style="text-align: center;">
  <h2>Starting Place: <?php echo $row["starting_place"]; ?></h2>
  <h2>Ending Place: <?php echo $row["ending_place"]; ?></h2>
  <?php
    $images = explode(',', $row["image"]);
    foreach($images as $image) {
      echo "<img src='$image' style='margin: auto;' />";
    }
  ?>
</div>

    <div class="details">
        <p><b>Waypoints:</b> <?php echo $row["waypoints"]; ?></p>
        <p><b>Famous Places:</b> <?php echo $row["famous_places"]; ?></p>
        <p><b>Tourist Places:</b> <?php echo $row["tourist_places"]; ?></p>
        <p><b>Travel Distance:</b> <?php echo $row["travel_distance"]; ?></p>
        <p><b>Travel Time:</b> <?php echo $row["travel_time"]; ?></p>
        <p><b>How to Reach:</b> <?php echo $row["how_to_reach"]; ?></p>
        <p><b>Description:</b> <?php echo $row["description"]; ?></p>
    </div>
            <?php
          }
        } else {
          echo "0 results";
        }

        mysqli_close($conn);
      }
    ?>

<script>
  var slideIndex = 0;
  showSlides();

  function showSlides() {
    var i;
    var slides = document.getElementsByTagName("img");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    slides[slideIndex-1].style.display = "block";
    setTimeout(showSlides, 3000); 
  }
</script>
<footer class="footer" id="footer">
          <p>&copy; 2023 My Website. All rights reserved.</p>
  </footer>
  </body>
</html>
