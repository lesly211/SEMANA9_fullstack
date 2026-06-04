<?php

require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si alguien accede directamente por GET → 405 Method Not Allowed
    http_response_code(405);
    die('<h2 style="font-family:sans-serif;color:#e11d48">
          405 – Método no permitido. Usa el formulario.</h2>');
}

$nombre  = filter_input(INPUT_POST, 'nombre',  FILTER_SANITIZE_SPECIAL_CHARS);
$email   = filter_input(INPUT_POST, 'email',   FILTER_VALIDATE_EMAIL);
$mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_SPECIAL_CHARS);

$errores = [];

if (empty($nombre) || strlen(trim($nombre)) < 3) {
    $errores[] = 'El nombre debe tener al menos 3 caracteres.';
}
if ($email === false || $email === null) {
    $errores[] = 'El correo electrónico no es válido.';
}
if (empty($mensaje) || strlen(trim($mensaje)) < 10) {
    $errores[] = 'El mensaje debe tener al menos 10 caracteres.';
}

if (empty($errores)) {
    $_SESSION['ultimo_envio'] = [
        'nombre'  => $nombre,
        'email'   => $email,
        'mensaje' => $mensaje,
        'hora'    => date('H:i:s'),
        'fecha'   => date('d/m/Y'),
    ];
    $exito = true;
} else {
    $exito = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Respuesta del Servidor – Lab09</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #0f172a;
      color: #e2e8f0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }
    .card {
      background: #1e293b;
      border: 1px solid #334155;
      border-radius: 12px;
      padding: 2.5rem;
      width: 100%;
      max-width: 540px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .status-ok  { color: #4ade80; font-size: 3rem; }
    .status-err { color: #f87171; font-size: 3rem; }
    h1 { font-size: 1.5rem; margin: 0.6rem 0 0.4rem; }
    .sub { color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.6rem; }
    .row {
      display: flex;
      justify-content: space-between;
      padding: 0.55rem 0;
      border-bottom: 1px solid #334155;
      font-size: 0.9rem;
    }
    .row:last-of-type { border-bottom: none; }
    .lbl { color: #64748b; }
    .val { color: #f1f5f9; font-weight: 600; max-width: 60%; text-align: right; word-break: break-word; }
    .errores {
      background: #450a0a;
      border: 1px solid #ef4444;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1.4rem;
    }
    .errores li { font-size: 0.88rem; color: #fca5a5; margin-left: 1.2rem; line-height: 1.8; }
    .debug {
      margin-top: 1.5rem;
      background: #0f172a;
      border: 1px solid #1e3a5f;
      border-radius: 8px;
      padding: 1rem;
      font-size: 0.78rem;
      color: #38bdf8;
      font-family: monospace;
      line-height: 1.7;
    }
    a.btn {
      display: inline-block;
      margin-top: 1.5rem;
      background: #0ea5e9;
      color: #fff;
      padding: 0.65rem 1.4rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
    }
    a.btn:hover { background: #0284c7; }
    .session-box {
      margin-top: 1.5rem;
      background: #0d2137;
      border: 1px dashed #0ea5e9;
      border-radius: 8px;
      padding: 0.9rem 1rem;
      font-size: 0.82rem;
      color: #7dd3fc;
    }
  </style>
</head>
<body>
<div class="card">

<?php if ($exito): ?>
  <div class="status-ok">✓</div>
  <h1>¡Formulario procesado!</h1>
  <p class="sub">El servidor recibió y validó los datos correctamente.</p>

  <!-- esc() aplica htmlspecialchars() para prevenir XSS -->
  <div class="row"><span class="lbl">Nombre</span>  <span class="val"><?= esc($nombre)  ?></span></div>
  <div class="row"><span class="lbl">Email</span>   <span class="val"><?= esc($email)   ?></span></div>
  <div class="row"><span class="lbl">Mensaje</span> <span class="val"><?= esc($mensaje) ?></span></div>
  <div class="row"><span class="lbl">Hora</span>    <span class="val"><?= date('H:i:s') ?></span></div>
  <div class="row"><span class="lbl">IP cliente</span><span class="val"><?= esc($_SERVER['REMOTE_ADDR']) ?></span></div>

  <div class="session-box">
    <strong>Sesión activa:</strong> session_id = <code><?= session_id() ?></code><br>
    Datos guardados en <code>$_SESSION['ultimo_envio']</code> para esta sesión HTTP.
  </div>

<?php else: ?>
  <div class="status-err">✗</div>
  <h1>Errores de validación</h1>
  <p class="sub">Corrige los siguientes campos e intenta de nuevo.</p>

  <div class="errores">
    <ul>
      <?php foreach ($errores as $e): ?>
        <li><?= esc($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
  <div class="debug">
    <strong>// DEBUG – Request Info</strong><br>
    REQUEST_METHOD : <?= esc($_SERVER['REQUEST_METHOD']) ?><br>
    SERVER_SOFTWARE: <?= esc($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') ?><br>
    HTTP_HOST      : <?= esc($_SERVER['HTTP_HOST'] ?? 'N/A') ?><br>
    PHP_VERSION    : <?= phpversion() ?><br>
    STATUS HTTP    : <?= $exito ? '200 OK' : '422 Unprocessable Entity' ?>
  </div>

  <a class="btn" href="index.html">← Volver al formulario</a>
</div>
</body>
</html>
