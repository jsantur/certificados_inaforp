<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/app.php';

$error = false;
$redirect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['codigo'])) {
    $codigo = trim($_POST['codigo']);
    $stmt = $pdo->prepare("SELECT key_hash FROM certificados WHERE codigo = :codigo");
    $stmt->execute(['codigo' => $codigo]);
    $cert = $stmt->fetch();
    if ($cert) {
        $redirect = $cert['key_hash'];
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<!-- saved from url=(0033)https://certificados.inaforp.com/ -->
<html lang="zxx" class="js"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <base href=".">
    
    <meta name="author" content="NEXTIUS">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Verifica tus certificados y comparte en todas tus redes sociales.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="https://nextius.com/favicon.ico">
    <!-- Page Title  -->
    <title>INAFORP S.A.C | Verificador Online</title>
    
      <!-- Datos Open Graph -->
      <meta property="og:title" content="INAFORP S.A.C | Verificador de Certificado">
      <meta property="og:type" content="article">
      <meta property="og:url" content="https://certificados.inaforp.com">
      <meta property="og:description" content="Verifica tus certificados y comparte en todas tus redes sociales.">
      <meta property="og:site_name" content="INAFORP S.A.C">
      <meta property="og:image" content="https://certificados.inaforp.com/admin/backgrounds/promo1.png">
  
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="assets/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="assets/theme.css">
</head>

<style>
      .redirect-overlay {
          display: none;
          position: fixed;
          inset: 0;
          background: rgba(255,255,255,0.9);
          z-index: 9999;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          gap: 14px;
      }
      .redirect-overlay.show { display: flex; }
      .spinner {
          width: 40px; height: 40px;
          border: 4px solid #dbdfea;
          border-top-color: #6546D2;
          border-radius: 50%;
          animation: spin 0.8s linear infinite;
      }
      @keyframes spin { to { transform: rotate(360deg); } }
</style>
<body class="nk-body ui-rounder npc-general pg-auth">
    <?php if ($redirect): ?>
    <div class="redirect-overlay show">
      <div class="spinner"></div>
      <p style="font-weight: bold; color: #364a63; margin-top: 10px;">Verificando certificado...</p>
    </div>
    <script>
      setTimeout(function() {
        window.location.href = '<?php echo app_url('visor/?key=' . urlencode($redirect)); ?>';
      }, 1000);
    </script>
    <?php endif; ?>
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="#" class="logo-link" onclick="event.preventDefault(); location.reload();"> 
                                <img class="logo-dark logo-img logo-img-lg" src="assets/logooo.png" alt="logo-dark" style="width: 60%;">
                            </a>
                        </div>
                        
                        <div class="card">
                            <img src="assets/certificado-top.png" alt="certificado" class="certificado-img" style="width: 100%;">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head" style="    text-align: center;">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Verificador Online</h4>
                                        <div class="nk-block-des">
                                            <p>Ingrese el ID del Certificado.</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="errorpro" class="errorpro" style="display: <?php echo $error ? 'block' : 'none'; ?>;">
                                    ¡Código o ID de Certificado Incorrecto!
                                </div>
                                <?php if ($error): ?>
                                <script>
                                    setTimeout(function() {
                                        document.getElementById('errorpro').style.display = 'none';
                                    }, 5000);
                                </script>
                                <?php endif; ?>
                                
                                <style>
                                    .errorpro {
                                        background: #f5688b;
                                        color: #fff;
                                        text-align: center;
                                        border-radius: 5px;
                                        margin-bottom: 15px;
                                    }
                                </style>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <div class="form-label-group" style="display:none;">
                                            <label class="form-label" for="codigo">Código o ID del Certificado</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" name="codigo" id="codigo" placeholder="Ingrese el código o ID del Certificado" value="<?php echo isset($_POST['codigo']) ? htmlspecialchars($_POST['codigo']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Verificar Certificado</button>
                                    </div>
                                </form>

                                <div class="form-note-s2 text-center pt-4"> ¿Tu código o ID no es válido? <a href="#" onclick="event.preventDefault(); document.getElementById('codigo').value=''; document.getElementById('codigo').focus();">Consultar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">
                                        
                                        © <span id="yearnextius">2026</span> Powered By <a href="#" onclick="event.preventDefault(); location.reload();">NEXTIUS.com</a>
                                        <script>fecha = new Date();year = fecha.getFullYear();document.getElementById('yearnextius').innerHTML = year;</script>
                                        
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="assets/bundle.js.descarga"></script>
    <script src="assets/scripts.js.descarga"></script>

</body></html>