
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

h1, h2 {
    color: #333;
}

form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

button{
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}
button:hover {
    background-color: #45a049;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #4caf50;
    color: #fff;
}

 </style>
</head>
<html>
    <body>
    <?php
    session_start();

    function courseExists($code)
    {
        if (!empty($_SESSION['courses'])) {
            foreach ($_SESSION['courses'] as $course) {
                if ($course['code'] == $code) {
                    return true;
                }
            }
        }
        return false;
    }

    if(!isset($_SESSION['courses'])){
        $_SESSION['courses'] = array();
    }

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if (isset($_POST["code"])) {
        $code = $_POST["code"];
        $titre = $_POST["titre"];
        $prof = $_POST["prof"];
        $nbOfCredits = $_POST["nbOfCredits"];
        $maxNbOfStds = $_POST["maxNbOfStds"];

        $existingCourseIndex = courseExists($code);

        if ($existingCourseIndex === false) {
            $coursesInfo = array(
                'code' => $code,
                'titre' => $titre,
                'prof' => $prof,
                'nbOfCredits' => $nbOfCredits,
                'maxNbOfStds' => $maxNbOfStds,
            );

            $_SESSION['courses'][] = $coursesInfo;
        } else {
            echo "<p style='color:red;'>Course with code $code already exists. Please choose a different code.</p>";
        }
    }

    
    if (!empty($_POST["modifyCode"])) {
        $modifyCode = $_POST["modifyCode"];
        $newProf = $_POST["newProf"];

        $existingCourseIndex = courseExists($modifyCode);

        if ($existingCourseIndex !== false) {
            $_SESSION['courses'][$existingCourseIndex]['prof'] = $newProf;
            echo "<p style='color:green;'>Professor's name for course with code $modifyCode modified successfully.</p>";
        } else {
            echo "<p style='color:red;'>Course with code $modifyCode not found. Please enter a valid code.</p>";
        }
    }
} 

if(!empty($_SESSION['courses'])){
    echo "<h2>Course Information Table</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Code</th><th>Title</th><th>Professor</th><th>Credits</th><th>Max Students</th></tr>";

        foreach ($_SESSION['courses'] as $course) {
            echo "<tr>";
            echo "<td>" . $course['code'] . "</td>";
            echo "<td>" . $course['titre'] . "</td>";
            echo "<td>" . $course['prof'] . "</td>";
            echo "<td>" . $course['nbOfCredits'] . "</td>";
            echo "<td>" . $course['maxNbOfStds'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
}
  ?>
  <button onclick="location.href='coursesInfoFrom.html'">
                <span>Back</span>
            </button>
    </body>
</html>