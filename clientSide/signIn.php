<?php
include 'index.php';
// var_dump($_POST);

//retrieve data sent via post method
$clientName = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : 'clientName';
$clientLastName = isset($_POST['lastname']) ? $conn->real_escape_string($_POST['lastname']) : 'clientLastName';
$clientEmail = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : 'default@gmail.com';
$clientCell = isset($_POST['cellphone']) ? $conn->real_escape_string($_POST['cellphone']) : 'xxxxxxxx';

//function to validate if a client truly exists upon login
function clienteExiste($conn, $clientName, $clientLastName, $clientEmail, $clientCell) {
    $query = "SELECT clientID FROM clients WHERE email = '$clientEmail' AND cellphone = '$clientCell' AND firstName = '$clientName' AND lastName = '$clientLastName'"; //query to check if the client already exists
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) { // If the query returns more than 0 rows i.e the client exists
        return mysqli_fetch_assoc($result)['clientID']; // returns clientID 
    }
    return false;
}

//retreiving the clientID                       
$clientID = clienteExiste($conn, $clientName, $clientLastName, $clientEmail, $clientCell);

if (!$clientID) { //if the client id does not exists
    header('Location: redirectSigin.html'); // Redirect to create account page if client does not exist
    exit();
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Menu de Opciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta charset="UTF-8">
    <link href="menu.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="display-1">¿Qué desea hacer?</h1>

        <div class="container1">
            <div class="card" style="width: 18rem;">
                <img src="verCitas.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <form action="sacarCita.php" method="post">
                        <input type="hidden" name="clientID" value="<?=$clientID;?>">
                        <button type="submit" class="btn btn-primary">Sacar Cita</button>
                    </form>
                </div>
            </div>

            <div class="card" style="width: 18rem;">
                <img src="cancelarCita.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <form action="verCitas.php" method="post">
                        <input type="hidden" name="clientID" value="<?=$clientID;?>">
                        <button type="submit" class="btn btn-primary">Ver/Cancelar Mis Citas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

