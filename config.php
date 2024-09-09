    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sales_management";

    $conn = new mysqli($servername, $username, $password, $dbname);

    //check connection

    if ($conn->connect_error) {
        die("Connection Failed" . $conn->connect_error);
    }


    ?>