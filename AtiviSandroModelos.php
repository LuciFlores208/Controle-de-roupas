<?php
include_once 'conexao.php';


$result = $conn->query("SELECT * FROM modelo");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roupas</title>
    <h3>Controle de Roupas</h3>
    <style>

h3 {
            text-align: center;
            width: 100%;
            margin: 20px 0 10px 0;
            color: #000000;
            font-weight: bold;
        }

 header {
            width: 100%;
            background-color: #ffffff;
            padding: 15px 0;
            border-bottom: 1px solid #ddd; 
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center; 
            margin: 0;
            padding: 0;
            gap: 40px; 
        }

        nav a {
            color: #000000;
            text-decoration: none;
            transition: 0.3s;
            font-size: 24px; 
            font-weight: bold;
        }

        nav a:hover {
            color: #666;
        }

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
 
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
 
tr:nth-child(even) {
  background-color: #dddddd;
}
 
 table {
        width: 50%;
        margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
        text-align: center;
    }
    table, th, td {
        border: 1px solid black;
    }
 
   
    </style>
<?php
include_once 'menu.php';
?>
</head>
 
<body style="display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-start; gap: 20px; font-family: arial, sans-serif;">

  <h1 style="font-family: arial, sans-serif; width: 100%; margin-bottom: 10px; text-align: center;">Modelo</h1>
    <table style= "width: 70%; border-collapse: collapse; border: 1px solid black; margin: 0; text-align: center;">
        <thead>
        <tr>
           <th>Modelo</th>
           <th>Roupa</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
        <td><?php echo $row['idModelo'] ?></td>
        <td><?php echo $row['Nome'] ?></td>
        
        </tr>
        <?php endwhile; ?>
        </tbody>
         </table>

 
</body>
</html>