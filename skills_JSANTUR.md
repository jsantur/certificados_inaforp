# Skills de Desarrollo Asistido — Certificados INAFORP (JSANTUR)
**Versión:** 1.0  
**Mantenido por:** Antigravity AI + equipo de desarrollo  
**Última validación:** 2026-06-16  

## Propósito del documento
Guiar a la IA para que realice **modificaciones seguras** en el sistema de verificación y visualización de Certificados INAFORP, evitando regresiones en:
- Fidelidad visual de los certificados estáticos (PNG, PDF).
- Compatibilidad con PHP 8.2+ (evitar métodos deprecados).
- Integración y búsqueda de base de datos MySQL por `key_hash` y `codigo`.
- Consistencia del diseño frontend del Verificador (DashLite).

**Regla de oro ante la duda:** Preguntar al usuario antes de cambiar cualquier lógica marcada como [INMUTABLE].

---

## 1. Arquitectura de Generación y Visualización de Certificados

### 1.1 Generación de Recursos (PDF / PNG / QR)
| Elemento | Detalle | Riesgo si se modifica |
|----------|---------|------------------------|
| **Fidelidad del Diseño** | [INMUTABLE] Por directiva del usuario, debido a la complejidad visual de los certificados originales (múltiples firmas, sellos, márgenes decorativos), **ESTÁ ESTRICTAMENTE PROHIBIDO** intentar reconstruir el certificado de forma dinámica montando textos sobre fondos mediante FPDF o librerías GD (`imageTtfText`). | Pérdida de calidad visual, desalineación de textos o pérdida de elementos gráficos vitales. |
| **Archivos Estáticos** | Los endpoints generadores (`temp/certificado-pdf.php`, `temp/certificado-png.php`, `temp/certificado-qr.php`) deben limitarse a **servir y redirigir** a los archivos pre-existentes de alta resolución ubicados en las carpetas `assets/` e `images/`. | Rompe la visualización y descarga de los certificados. |
| **Compatibilidad PHP 8.2+** | [CRÍTICO] Funciones como `utf8_decode()` y `strftime()` están **deprecadas** en el entorno Laragon actual. Si en el futuro se requiere dinamismo, usar `mb_convert_encoding()` y `date()` estándar. | Excepciones fatales y caídas del servidor local. |

### 1.2 Visor de Certificados (`visor/index.php`)
- **Fechas Dinámicas:** La visualización de la fecha de emisión se construye dinámicamente consultando la tabla `certificados` (`issue_date`, `issue_location`) formateando la salida al español (ej. "Lima, 30 de Abril del 2026").
- **Estructura de Enlaces:** Todos los enlaces internos de validación deben usar el formato oficial `https://certificados.inaforp.com/visor/?key={key_hash}` o rutas absolutas que carguen el hash de 32 caracteres.
- **Acceso Directo al Verificador:** El ícono superior derecho de diploma redirige estáticamente al sistema verificador (`/certificados_inaforp/admin-verificador/`).

---

## 2. Verificador de Certificados (`admin-verificador/index.php`)

### 2.1 Estructura Frontend y Diseño (DashLite)
- **Concepto:** Una página de validación construida utilizando el framework **DashLite**, con tipografías Roboto/Nunito, un modo oscuro/claro y componentes limpios.
- **Manejo de Assets:**
  - [INMUTABLE] Los estilos base deben permanecer conectados a la subcarpeta local **`assets/`** (`assets/dashlite.css`, `assets/theme.css`). 
  - La imagen miniatura del certificado (`assets/certificado-top.png`) y el logo institucional (`assets/logooo.png`) se cargan directamente de forma local desde `assets/`.

### 2.2 Flujo de Validación de Código (BD)
- **Consulta Backend:** Se captura el `codigo` ingresado (ej. `406394`) vía petición `POST`. El script principal realiza una búsqueda estricta comparando el campo `codigo` en la tabla `certificados`.
- **Match Exitoso:**
  - Si el código existe, se obtiene el `key_hash` asociado (ej. `6FD2D9...`).
  - Se activa una variable PHP `$redirect`.
  - [UI/UX] Se muestra instantáneamente un _overlay_ a pantalla completa bloqueando interacciones (`.redirect-overlay.show`), con un spinner CSS animado morado (#6546D2) y el texto "Verificando certificado...".
  - A través de JavaScript, tras 1000ms, se ejecuta la redirección final al visor del certificado usando la `key` descubierta.
- **Sin Coincidencias (Error):**
  - Si no existe el código, se levanta un _banner_ de error color rosa oscuro `#f5688b` (`.errorpro`).
  - [INMUTABLE] Este banner utiliza una función temporal `setTimeout` generada por PHP que auto-oculta el div al transcurrir exactamente 5000ms. 

### 2.3 Patrones de Comportamiento e Interactividad Rápida
- **Links de Recarga Silenciosa:** El pie de página "NEXTIUS.com" y el Logo superior institucional ejecutan silenciosamente: `onclick="event.preventDefault(); location.reload();"`.
- **Reinicio Activo de Formulario:** El enlace inferior **"Consultar"** ("¿Tu código no es válido?") no recarga ni viaja a otro lado. Vacía el valor del input `#codigo` actual y transfiere automáticamente el foco de edición para reintentar la escritura.

---

## 3. Base de Datos (`database.sql` simulada)
- La arquitectura mínima viable de la tabla `certificados` contiene:
  - `id`: Autoincremental
  - `codigo`: ID corto de verificación que ingresan los usuarios manuales (ej. 406394).
  - `key_hash`: El Hash hexadecimal único de 32 caracteres MD5-like (`6FD2D9B4CFE23B8BA7A3D564313D8881`).
  - Al restaurar backups en el motor relacional, asegurar sincronizar los campos `key_hash` en todas las referencias (PDF, Visor, BD).
  - **Codificación de Caracteres**: [CRÍTICO] Al importar o modificar `database.sql`, asegurarse de incluir `SET NAMES utf8mb4;` y ejecutar la importación con soporte UTF-8 (por ej. `--default-character-set=utf8mb4` en consola) para evitar la corrupción de caracteres especiales (como tildes o eñes, previniendo que "ó" se muestre como "├│").

---

## 4. Ejemplo de Prompt para la IA (Copiar y Pegar antes de pedir cambios)

> Voy a solicitar una modificación en la plataforma de Certificados INAFORP. Por favor, respeta las siguientes reglas del documento Skills:
> - Bajo ninguna circunstancia intentes construir certificados FPDF uniendo tipografías e imágenes. **Debemos proveer los assets estáticos.**
> - El Verificador debe preservar la estructura nativa de DashLite cargando estilos de la carpeta `/assets`.
> - Mantener el flujo de validación en PHP y el overlay de carga con spinner antes de redirigir al Visor.
> - Ningún código debe utilizar `utf8_decode` o métodos deprecados de PHP 8.2+.
> - Después de sugerir el cambio, infórmame las pruebas requeridas en Localhost.

---

## 5. Registro de Cambios Recientes
- **[2026-06-17] Correcciones en la Base de Datos y Codificación:**
  - Se corrigió un error de duplicidad en la creación de la BD en `database.sql`.
  - Se insertó un nuevo certificado de prueba (Joseph Santur, `406245`).
  - Se implementó `SET NAMES utf8mb4;` en `database.sql` para forzar el charset UTF-8 al restaurar la base de datos y prevenir bugs visuales en caracteres especiales generados por la terminal de Windows.
