<?php
    // Server
    $server = "localhost";

    // Username
    $username = "root";

    // Password
    $password = "";

    // Database
    $database = "sales";

    // Global connection
    $connection = null;

    function connect() {
        global $server;
        global $username;
        global $password;
        global $database;
        global $connection;

        // Is $connection null?
        // If so, connect to the database server.
        // If not, do nothing (because the connection already exists).
        if($connection == null) {
            $connection = mysqli_connect($server, $username, $password, $database);
        }
    }

    function database_addUser($username, $password) {
        // Use the global connection
        global $connection;

        if($connection != null) {
            // Overwrite the existing password value as a hash
            $password = password_hash($password, PASSWORD_DEFAULT);
            // Insert username and hashed password
            mysqli_query($connection, "INSERT INTO users (username, password) VALUES ('{$username}', '{$password}');");
        }
    }

    function database_deleteUser($username, $password) {

        $status = database_verifyUser($username, $password);

        if($status == true){
            // Use the global connection
            global $connection;

            if($connection != null) {
                // Overwrite the existing password value as a hash
                $password = password_hash($password, PASSWORD_DEFAULT);
                // Insert username and hashed password
                mysqli_query($connection, "DELETE FROM users WHERE username = '{$username}';");
            }
        }
    }
    function salesTable() {
        // Use global $connection locally.
        global $connection;

         // Is $connection null?
         // If so, do nothing (because a connection has not been made yet).
        if($connection != null) {
            // Get the results of a query using the connection
            // TODO: Write SQL SELECT statement to read first name, last name, city, and state.
            $results = mysqli_query($connection, "SELECT * FROM customers");

            // Start the HTML table.
            echo("<table><tbody>");

            // For every row, generate a new HTML row.
            while($row = mysqli_fetch_assoc($results)) {
                // Start the row.
                echo("<tr>");

                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                
                // End the row.
                echo("</tr>");
            }

            // End the HTML table.
            echo("</tbody></table>");
        }
    }

    function database_updatePassword($username, $originalPassword, $newPassword) {

        $status = database_verifyUser($username, $password);

        if($status == true){
            // Use the global connection
            global $connection;

            if($connection != null) {
                // Overwrite the existing password value as a hash
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                // Insert username and hashed password
                mysqli_query($connection, "Update users SET password = '{$newPassword}' WHERE username = '{$username}';");
            }
        }
    }

    function database_verifyUser($username, $password) {
        // Use the global connection
        global $connection;

        // Create a default value
        $status = false;

        if($connection != null) {
            // Use WHERE expressions to look for username
            $results = mysqli_query($connection, "SELECT password FROM users WHERE username = '{$username}';");
            
            // mysqli_fetch_assoc() returns either null or row data
            $row = mysqli_fetch_assoc($results);
            
            // If $row is not null, it found row data.
            if($row != null) {
                // Verify password against saved hash
                if(password_verify($password, $row["password"])) {
                    $status = true;
                }
            }
        }

        return $status;
    }

    function close() {
        // Use the global $connection locally.
        global $connection;

        // Unlike connect(), we test for a value *not* equal to null.
        if($connection != null) {
            // Close the connection.
            mysqli_close($connection);
        }
    } 
?>