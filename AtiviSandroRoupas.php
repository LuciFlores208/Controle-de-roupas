<?php
include_once 'conexao.php';

/* ===== DELETE ===== */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM roupas WHERE idRoupas = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

/* ===== ADICIONAR ===== */
if (isset($_POST['add'])) {

    $modelo_nome = trim($_POST['Modelo']);
    $modelo_nome_normalizado = strtolower($modelo_nome);

    $cor = mb_convert_case(trim($_POST['Cor']), MB_CASE_TITLE, "UTF-8");

    $marca = $_POST['Marca'];
    $tamanho = $_POST['Tamanho'];
    $sex = $_POST['Sex'];

    // MODELO
    $stmt = $conn->prepare("SELECT idModelo FROM modelo WHERE LOWER(Nome) = ?");
    $stmt->bind_param("s", $modelo_nome_normalizado);
    $stmt->execute();
    $result_modelo = $stmt->get_result();

    if ($result_modelo->num_rows > 0) {
        $row = $result_modelo->fetch_assoc();
        $idModelo = $row['idModelo'];
    } else {
        $stmt = $conn->prepare("INSERT INTO modelo (Nome) VALUES (?)");
        $stmt->bind_param("s", $modelo_nome);
        $stmt->execute();
        $idModelo = $stmt->insert_id;
    }

    // INSERT
    $stmt = $conn->prepare("INSERT INTO roupas (idModelo, idMarca, idTamanhos, Cor, Sex) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $idModelo, $marca, $tamanho, $cor, $sex);
    $stmt->execute();
}

/* ===== EDITAR ===== */
if (isset($_POST['editar'])) {

    $id = intval($_POST['edit_id']);

    $modelo_nome = trim($_POST['Modelo']);
    $modelo_nome_normalizado = strtolower($modelo_nome);

    $cor = mb_convert_case(trim($_POST['Cor']), MB_CASE_TITLE, "UTF-8");

    $marca = $_POST['Marca'];
    $tamanho = $_POST['Tamanho'];
    $sex = $_POST['Sex'];

    // MODELO
    $stmt = $conn->prepare("SELECT idModelo FROM modelo WHERE LOWER(Nome) = ?");
    $stmt->bind_param("s", $modelo_nome_normalizado);
    $stmt->execute();
    $result_modelo = $stmt->get_result();

    if ($result_modelo->num_rows > 0) {
        $row = $result_modelo->fetch_assoc();
        $idModelo = $row['idModelo'];
    } else {
        $stmt = $conn->prepare("INSERT INTO modelo (Nome) VALUES (?)");
        $stmt->bind_param("s", $modelo_nome);
        $stmt->execute();
        $idModelo = $stmt->insert_id;
    }

    // UPDATE
    $stmt = $conn->prepare("UPDATE roupas SET idModelo=?, idMarca=?, idTamanhos=?, Cor=?, Sex=? WHERE idRoupas=?");
    $stmt->bind_param("iiissi", $idModelo, $marca, $tamanho, $cor, $sex, $id);
    $stmt->execute();
}

/* ===== SELECT ===== */
$sql = "SELECT 
    roupas.idRoupas AS roupas_nome,
    modelo.Nome AS roupas_modelo,
    marca.Nome AS roupas_marca,
    tamanhos.Tipo AS roupas_tamanho,
    roupas.Cor AS roupas_cor,
    roupas.Sex AS roupas_sex
FROM roupas
JOIN marca ON roupas.idMarca = marca.idMarca
JOIN modelo ON roupas.idModelo = modelo.idModelo
JOIN tamanhos ON roupas.idTamanhos = tamanhos.idTamanhos";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roupas</title>
    <h1>Controle de Roupas</h1>
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
    }
    table, th, td {
        border: 1px solid black;
    }
 
    
    </style>

</head>
 
<body style="display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-start; gap: 20px; font-family: arial, sans-serif;">
    <h1 style="font-family: arial, sans-serif; width: 100%; margin-bottom: 10px; text-align: center;">Roupa</h1>
    <table style= "width: 70%; border-collapse: collapse; border: 1px solid black; margin: 0;">
        <thead>
        <tr>
           <th>Roupa</th>
           <th>Modelo</th>
           <th>Marca</th>
           <th>Cor</th>
           <th>Tamanho</th>
           <th>Fem/Man</th>
           <th>Apagar</th>
           <th>Editar</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
        <td><?php echo $row['roupas_nome'] ?></td>
        <td><?php echo $row['roupas_modelo'] ?></td>
        <td><?php echo $row['roupas_marca'] ?></td>
        <td><?php echo $row['roupas_cor'] ?></td> 
        <td><?php echo $row['roupas_tamanho'] ?></td>
        <td><?php echo $row['roupas_sex'] ?></td>
        <td><a href="?delete=<?php echo $row['roupas_nome']; ?>">&times;</a></td>
        <td>
<button onclick="mostrarEdicao(
<?php echo $row['roupas_nome']; ?>,
'<?php echo $row['roupas_modelo']; ?>',
'<?php echo $row['roupas_marca']; ?>',
'<?php echo $row['roupas_cor']; ?>',
'<?php echo $row['roupas_tamanho']; ?>',
'<?php echo $row['roupas_sex']; ?>'
)">
✏️
</button>
</td>
        </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
         </table>
<div class="Edicao"></div>
  <details>
    <summary>Adicionar</summary>

    <form method="POST" style="border: 1px solid #ccc; padding: 10px; margin-top: 5px; display: flex; flex-direction: column; gap: 10px; width: fit-content;">

        <label>Modelo:</label>
        <input type="text" name="Modelo" placeholder="Digite o modelo" required>

        <label>Marca:</label>
        <select name="Marca">
            <option value="1">Chanel</option>
            <option value="2">Gucci</option>
            <option value="3">Prada</option>
            <option value="4">Louis Vuitton</option>
            <option value="5">Hermes</option>
        </select>

        <label>Cor:</label>
        <input type="text" name="Cor" placeholder="Digite a cor" required>

        <label>Tamanho:</label>
        <select name="Tamanho">
            <option value="1">XPP</option>
            <option value="2">PP</option>
            <option value="3">P</option>
            <option value="4">M</option>
            <option value="5">G</option>
            <option value="6">GG</option>
        </select>

        <label>Sex:</label>
        <select name="Sex">
            <option value="Fem">Fem</option>
            <option value="Man">Man</option>
        </select>

        <button type="submit" name="add">Adicionar</button>

    </form>
 </details>

 <script>
function mostrarEdicao(id, modelo, marca, cor, tamanho, sex) {

    const div = document.querySelector('.Edicao');

    div.innerHTML = `
        <form method="POST" style="border:1px solid #ccc; padding:10px; margin-top:10px; display:flex; flex-direction:column; gap:10px;">

            <input type="hidden" name="edit_id" value="${id}">

            <label>Modelo:</label>
            <input type="text" name="Modelo" value="${modelo}" required>

            <label>Marca:</label>
            <select name="Marca" id="editMarca">
                <option value="1">Chanel</option>
                <option value="2">Gucci</option>
                <option value="3">Prada</option>
                <option value="4">Louis Vuitton</option>
                <option value="5">Hermes</option>
            </select>

            <label>Cor:</label>
            <input type="text" name="Cor" value="${cor}" required>

            <label>Tamanho:</label>
            <select name="Tamanho" id="editTamanho">
                <option value="1">XPP</option>
                <option value="2">PP</option>
                <option value="3">P</option>
                <option value="4">M</option>
                <option value="5">G</option>
                <option value="6">GG</option>
            </select>

            <label>Sex:</label>
            <select name="Sex" id="editSex">
                <option value="Fem">Fem</option>
                <option value="Man">Man</option>
            </select>

            <div style="display:flex; gap:10px;">
                <button type="submit" name="editar">Salvar</button>
                <button type="button" onclick="cancelarEdicao()">Cancelar</button>
            </div>

        </form>
    `;

    setTimeout(() => {

        const marcas = {
            "Chanel": "1",
            "Gucci": "2",
            "Prada": "3",
            "Louis Vuitton": "4",
            "Hermes": "5"
        };

        const tamanhos = {
            "XPP": "1",
            "PP": "2",
            "P": "3",
            "M": "4",
            "G": "5",
            "GG": "6"
        };

        document.getElementById("editMarca").value = marcas[marca];
        document.getElementById("editTamanho").value = tamanhos[tamanho];
        document.getElementById("editSex").value = sex;

    }, 50);
}

/* ===== NOVA FUNÇÃO ===== */
function cancelarEdicao() {
    const div = document.querySelector('.Edicao');
    div.innerHTML = ""; // remove o formulário
}
</script>
</div>
 
</body>
</html>