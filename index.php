<html>
<body style="background-color:#FDF2E9">
<head>
<title>SMT Movie Rental</title>
<style>
.error {color: #FF0000;}
.content {
  max-width: 500px;
  margin: auto;
  background: #FAE5D3;
  padding: 10px;
}
.block {
  width: 100%;
  border: none;
  background-color: #CA6F1E;
  color: white;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
}

</style>
<?php require 'header.php';?> /* header of the page */
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {        
    $title = Chkinput($_POST["title"]);  
    $rating = Chkinput($_POST["rating"]);  
    $year = Chkinput($_POST["year"]);  
    $genre = Chkinput($_POST["genre"]);  
}

/* Check input data before pass*/
function Chkinput($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
    $dbConnect = mysqli_connect("localhost", "root", "", "MovieRentals");
    /* check connection */
if (!$dbConnect) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

<div class="content">
<center><h2>Search Movies</h2></center>

<form method="post" action="/MovieSearch.php <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    Movie Title: <input type="text" name="title">
    <br><br><br>
<?php	
	/* get unique values from the existing database to show on the webpage, This makes sthe page more userfriendly*/
	/* Ratings of the movies */
    $sql = "Select DISTINCT Rating from Movies;"; 
if ($result = mysqli_query($dbConnect, $sql)) {                    
    echo "Rating: <input list='rating' name='rating'>";
    echo "<datalist id='rating'>";
    while($record = mysqli_fetch_assoc($result)) {             
        echo "<option value='".$record['Rating']."'>".$record['Rating']."</option>";                
    }
    echo "</datalist>";
    mysqli_free_result($result);  
}else {
    printf("%s.<br />\n", mysqli_error($dbConnect));
}
    echo"<br><br><br>";
    
	/* Years of the movies */
    $sql = "Select DISTINCT Year from Movies ORDER BY Year DESC;"; 
if ($result = mysqli_query($dbConnect, $sql)) {            
    echo "Year Released: <input list='year' name='year'>";
    echo "<datalist id='year'>";
    while($record = mysqli_fetch_assoc($result)) { 
        echo "<option value='".$record['Year']."'>".$record['Year']."</option>";                
    }
    echo "</datalist>";
    mysqli_free_result($result);  
}else {
    printf("%s.<br />\n", mysqli_error($dbConnect));
}
    echo"<br><br><br>";
    

    
    /* close connection */
    mysqli_close($dbConnect);
?>

  
<?php require 'footer.php';?>
</body>
</html>
