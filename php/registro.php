<?php
// registro.php

$host = 'tu-host.supabase.co'; // cambia por tus datos
$port = '5432';
$dbname = 'tu_base_de_datos';
$user = 'tu_usuario';
$password = 'tu_contraseña';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

$usuario = $_POST['usuario'] ?? '';
$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';
$edad = $_POST['edad'] ?? 0;
$genero = $_POST['genero'] ?? '';
$educacion = $_POST['educacion'] ?? '';
$estado_civil = $_POST['estado_civil'] ?? '';
$region = $_POST['region'] ?? '';
$comuna = $_POST['comuna'] ?? '';

if (!$usuario || !$email || !$pass) {
    die('Faltan datos obligatorios');
}

$pass_hash = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios 
    (usuario, email, password, edad, genero, educacion, estado_civil, region, comuna) 
    VALUES (:usuario, :email, :password, :edad, :genero, :educacion, :estado_civil, :region, :comuna)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':usuario' => $usuario,
        ':email' => $email,
        ':password' => $pass_hash,
        ':edad' => $edad,
        ':genero' => $genero,
        ':educacion' => $educacion,
        ':estado_civil' => $estado_civil,
        ':region' => $region,
        ':comuna' => $comuna
    ]);
    echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'duplicate key') !== false) {
        echo "El email ya está registrado.";
    } else {
        echo "Error al registrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro - Plataforma Salud Mental</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #23bcd7, #112244);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      color: #fff;
    }

    .container {
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 12px;
      width: 95%;
      max-width: 700px;
      backdrop-filter: blur(10px);
      overflow-y: auto;
      max-height: 95vh;
      text-align: center;
	  
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .form-group {
      flex: 1 1 45%;
    }

    input, select {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
      border: none;
      border-radius: 6px;
      background: rgba(0, 0, 0, 0.2);
      color: #fff;
      box-sizing: border-box;
      appearance: none;
	   border: 1px solid rgba(255, 255, 255, 0.3);
    }

    select {
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    select option {
      color: #000;
    }

    input::placeholder, select {
      color: rgba(255, 255, 255, 0.8);
    }

    input:focus, select:focus {
      background: rgba(255, 255, 255, 0.3);
      outline: none;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
    }

    #comuna:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    .full-width {
      flex: 1 1 100%;
    }

    button {
      background: #00bcd4;
      color: #fff;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      margin-top: 15px;
      cursor: pointer;
    }

    button:hover {
      background: #0097a7;
    }

    .note {
      text-align: center;
      font-size: 0.9em;
      margin-top: 10px;
    }
	:root {
      --accent-primary: #56dbc4; /* verde */
      --accent-secondary: #00bcd4; /* cian */
      --text-light: #e0e0e0;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
   
	 a.btn { display:inline-block; padding:14px 28px; border-radius:30px; font-weight:600; text-decoration:none; transition:background .3s ease,color .3s ease,border .3s ease; }
    a.btn-primary {display: inline-block; width: 150px; text-align: center; margin: 5px; padding: 12px 0; border-radius: 30px; text-decoration: none; font-weight: bold; transition: background 0.3s ease; background:var(--accent-primary); color:#141e30; }
    a.btn-primary:hover { background:#56dbc4; color:#fff; }
 p {
            margin-top: 15px;
            font-size: 14px;
        }
        a {
            color: #f999b7;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
       
  </style>
</head>
<body>
  <div class="container">
    <img src="salud-mental.png" alt="Logo" width="100" height="100">
<br><br>
     <form method="post" action="registro.php" onsubmit="return validarFormulario()">
      <div class="form-group">
        <input type="text" name="usuario" placeholder="Usuario" required>
      </div>

      <div class="form-group">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <span class="error" id="email-error"></span>
      </div>

      


      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
        <span class="error" id="password-error"></span>
      </div>

      <div class="form-group">
        <input type="password" id="repetir_password" placeholder="Repita Contraseña" required>
        <span class="error" id="repetir-password-error"></span>
      </div>

      <div class="form-group">
        <input type="number" name="edad" placeholder="Edad" min="10" max="120" required>
      </div>

      <div class="form-group">
        <select name="genero" required>
          <option disabled selected>Género</option>
          <option>Masculino</option>
          <option>Femenino</option>
          <option>No binario</option>
          <option>Otro</option>
          <option>Prefiero no decirlo</option>
        </select>
      </div>

      <div class="form-group">
        <select name="educacion" required>
          <option disabled selected>Educación</option>
          <option>Básica incompleta</option>
          <option>Básica completa</option>
          <option>Media incompleta</option>
          <option>Media completa</option>
          <option>Educación técnica</option>
          <option>Universitaria incompleta</option>
          <option>Universitaria completa</option>
          <option>Postgrado</option>
        </select>
      </div>

      <div class="form-group">
        <select name="estado_civil" required>
          <option disabled selected>Estado Civil</option>
          <option>Soltero/a</option>
          <option>Casado/a</option>
          <option>Unión libre</option>
          <option>Separado/a</option>
          <option>Divorciado/a</option>
          <option>Viudo/a</option>
        </select>
      </div>

  <div class="form-group">
    <select name="region" id="region" onchange="cargarComunas()" required>
      <option disabled selected>Región</option>
      <option value="metropolitana">Región Metropolitana</option>
      <option value="valparaiso">Valparaíso</option>
      <option value="biobio">Biobío</option>
      <option value="araucania">Araucanía</option>
      <option value="ohiggins">O'Higgins</option>
      <option value="maule">Maule</option>
      <option value="antofagasta">Antofagasta</option>
      <option value="coquimbo">Coquimbo</option>
      <option value="loslagos">Los Lagos</option>
      <option value="tarapaca">Tarapacá</option>
      <option value="atacama">Atacama</option>
      <option value="aysen">Aysén</option>
      <option value="magallanes">Magallanes</option>
      <option value="losrios">Los Ríos</option>
      <option value="aricayparinacota">Arica y Parinacota</option>
      <option value="ñuble">Ñuble</option>
    </select>
  </div>

  <div class="form-group" id="comuna-group">
    <select name="comuna" id="comuna" disabled required>
      <option disabled selected>Comuna</option>
    </select>
  </div>

      <div class="full-width">
	  <p style="text-align:center;">(*) Los datos demográficos solicitados en este formulario son para<br>analizar la estructura y evolución poblacional.</p><br>
	   <button type="submit" class="btn btn-primary" style="width:180px;">Regístrate</button>
         
        
      </div>
    </form>
	<p>¿Ya tienes una cuenta? <a href="login.html">Inicia sesión</a></p>
  </div>

  <script>
    const comunasPorRegion = {
      metropolitana: ["Santiago", "Puente Alto", "Maipú", "La Florida", "Las Condes", "Ñuñoa", "San Bernardo", "Pudahuel", "Recoleta", "Quilicura"],
      valparaiso: ["Valparaíso", "Viña del Mar", "Quilpué", "Villa Alemana", "San Antonio"],
      biobio: ["Concepción", "Talcahuano", "Chiguayante", "Los Ángeles", "Coronel"],
      araucania: ["Temuco", "Padre Las Casas", "Villarrica", "Angol"],
      ohiggins: ["Rancagua", "San Fernando", "Rengo"],
      maule: ["Talca", "Curicó", "Linares"],
      antofagasta: ["Antofagasta", "Calama", "Tocopilla"],
      coquimbo: ["La Serena", "Coquimbo", "Ovalle"],
      loslagos: ["Puerto Montt", "Osorno", "Castro"],
      tarapaca: ["Iquique", "Alto Hospicio"],
      atacama: ["Copiapó", "Vallenar"],
      aysen: ["Coyhaique", "Puerto Aysén"],
      magallanes: ["Punta Arenas", "Puerto Natales"],
      losrios: ["Valdivia", "La Unión"],
      aricayparinacota: ["Arica", "Putre"],
      ñuble: ["Chillán", "San Carlos"]
    };

    function cargarComunas() {
      const regionSelect = document.getElementById("region");
      const comunaSelect = document.getElementById("comuna");
      const region = regionSelect.value;

      comunaSelect.innerHTML = '<option disabled selected>Comuna</option>';

      if (comunasPorRegion[region]) {
        comunasPorRegion[region].forEach(comuna => {
          const option = document.createElement("option");
          option.value = comuna;
          option.textContent = comuna;
          comunaSelect.appendChild(option);
        });
        comunaSelect.disabled = false;
      } else {
        comunaSelect.disabled = true;
      }
    }
	function validarFormulario() {
  const email = document.getElementById("email");
  const repetirEmail = document.getElementById("repetir_email");
  const password = document.getElementById("password");
  const repetirPassword = document.getElementById("repetir_password");

  let valid = true;

  if (email.value !== repetirEmail.value) {
    alert("Los correos no coinciden");
    valid = false;
  }

  if (password.value !== repetirPassword.value) {
    alert("Las contraseñas no coinciden");
    valid = false;
  }

  return valid;
}

  </script>
  <script type="module">
import { supabase } from './supabase.js'

const form = document.querySelector('#registroForm')

form.addEventListener('submit', async (e) => {
  e.preventDefault()

  if (!validarFormulario()) return

  const formData = new FormData(form)
  const dataObj = Object.fromEntries(formData)

  // Evitamos enviar repetir_email y repetir_password
  delete dataObj.repetir_email
  delete dataObj.repetir_password

  const { data, error } = await supabase
    .from('usuarios')
    .insert([dataObj])

  if (error) {
    alert('Error al registrar: ' + error.message)
  } else {
    alert('Registro exitoso 🎉')
    window.location.href = 'login.html'
  }
})
</script>


</body>
</html>
