<html>
    <link rel="icon" href="Imagenes/Tec-Sup-Jal.ico">
    <link rel="stylesheet" href="Css/Estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function mostrarNombreArchivo() {
            var fotoInput = document.getElementById('foto');
            var nombreArchivo = document.getElementById('nombre-archivo');

            if (fotoInput.files && fotoInput.files.length > 0) {
            // Hay un archivo seleccionado.
                nombreArchivo.classList.add('archivo-seleccionado');
            } else {
            // No hay archivo seleccionado.
                nombreArchivo.classList.remove('archivo-seleccionado');
            }

            // Actualizar el texto con el nombre del archivo seleccionado
            nombreArchivo.textContent = fotoInput.files.length > 0 ? fotoInput.files[0].name : 'Selecciona un archivo';
        }
    </script>

    <script>
        function verificarContrasena() {
            var contrasena = document.getElementById('password').value;
            var mensajeContrasena = document.getElementById('mensaje-contrasena');
            var fortaleza = 0;
    
            // Longitud de la contraseña
            if (contrasena.length >= 8) {
                fortaleza++;
            }
    
            // Verificar si la contraseña contiene al menos una letra mayúscula
            if (/[A-Z]/.test(contrasena)) {
                fortaleza++;
            }
    
            // Verificar si la contraseña contiene al menos un número
            if (/\d/.test(contrasena)) {
                fortaleza++;
            }

            switch (fortaleza) {
                case 1:
                    mensajeContrasena.innerHTML = '<span style="color:red">Contraseña débil</span>';
                    break;
                case 2:
                    mensajeContrasena.innerHTML = '<span style="color:orange">Contraseña moderada</span>';
                    break;
                case 3:
                    mensajeContrasena.innerHTML = '<span style="color:green">Contraseña fuerte</span>';
                    break;
                default:
                    mensajeContrasena.innerHTML = '';
            }
        }
    </script>

    <script>
        function validarFormulario() {
            var pass1 = document.getElementById('password').value;
            var pass2 = document.getElementById('password2').value;
            var mensaje = document.getElementById('caracteres');

            if (pass1 != pass2) {
                mensaje.textContent = 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo.';
                return false;
            } else {
                mensaje.textContent = ''; // Limpiar el mensaje si las contraseñas coinciden
                return true;
            }
        }
    </script>

    <script>
        function validarCorreo() {
            // Expresión regular para validar el correo institucional
            var regex = /[a-zA-Z0-9._-]+@([a-zA-Z0-9]+)\.(tecmm)\.(edu)\.(mx)$/;
    
            // Obtener el valor del campo de correo
            var correo = document.getElementById('correo').value;
    
            // Obtener el elemento de mensaje de error
            var mensajeError = document.getElementById('mensajeError');
    
            // Verificar si el correo cumple con el formato
            if (regex.test(correo)) {
                // Si es válido, mostrar un mensaje de éxito
                mensajeError.innerHTML = '';
            } else {
                // Si no es válido, mostrar un mensaje de error
                mensajeError.innerHTML = 'El correo institucional no es válido';
            }
        }
    </script>

</html>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="Agregar_Usuario.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <div class="mb-3">
            <small id="mensaje-caracteres" class="form-text" style="color:red">*Recuerda que estos datos serán utilizados para darle seguimiento a tu solicitud.</small><br>
                <label for="numero" class="col-form-label">No. Control:</label>
                <input type="text" class="form-control" name="numero" id="numero" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="col-form-label">Nombre(s):</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="mb-3">
                <label for="paterno" class="col-form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" name="paterno" id="paterno" required>
            </div>
            <div class="mb-3">
                <label for="materno" class="col-form-label">Apellido Materno:</label>
                <input type="text" class="form-control" name="materno" id="materno">
            </div>
            <div class="mb-3">
                <label for="semestre" class="col-form-label">Semestre:</label><br>
                <select name="semestre" required>
                    <option value="" selected disabled>Selecciona un semestre</option>
                    <option value="1ro">1ro</option>
                    <option value="2do">2do</option>
                    <option value="3ro">3ro</option>
                    <option value="4to">4to</option>
                    <option value="5to">5to</option>
                    <option value="6to">6to</option>
                    <option value="7mo">7mo</option>
                    <option value="8vo">8vo</option>
                    <option value="9no">9no</option>
                    <option value="10mo">10mo</option>
                    <option value="11vo">11vo</option>
                    <option value="12vo">12vo</option>
                    <option value="13vo">13vo</option>
                    <option value="14vo">14vo</option>
                    <option value="15vo">15vo</option>
                </select>
            </div>
            <div class="mb-3">
                <!-- Consultar carreras en la base de datos -->
            <?php
                include('Bd.php');
                error_reporting(0);
                $consulta = mysqli_query($conexion, "SELECT * FROM carrera");
            ?>
                <label for="carrera" name="carrera" id="semestre">Carrera:</label><br>
                <select name="carrera" required>
                <?php    
                while ($fila = mysqli_fetch_assoc($consulta)):
                $id = $fila['Id_Carrera'];
                $Carrera = $fila['NombreCarrera'];
                echo "<option value=$id>$Carrera</option>";
                endwhile;
                ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="correo" class="col-form-label">Correo Institucional:</label>
                <input type="email" class="form-control" name="correo" id="correo" required placeholder="email" oninput="validarCorreo()">
                <span id="mensajeError" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="password" class="col-form-label">Contraseña:</label>
                <small id="mensaje-caracteres" class="form-text text-muted">La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.</small>
                <input type="password" class="form-control" name="password" id="password" required oninput="verificarContrasena()">
                <span id="mensaje-contrasena"></span>
            </div>
            <div class="mb-3">
                <label for="password2" class="col-form-label">Confirmar contraseña:</label>
                <input type="password" class="form-control" name="password2" id="password2" required>
                <small id="caracteres" class="form-text" style="color:red"></small>
            </div>
            <div class="mb-3">
                <label for="foto" class="col-form-label">Ingresa una foto:</label>
                <input type="file" class="image" name="foto" id="foto" accept="image/*" required onchange="mostrarNombreArchivo()">
                <label for="foto" class="btn btn-primary">Agregar</label>
                <span id="nombre-archivo">Agregar archivo</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="Registrar" value="Registrar">
            </div>
        </form>
        </div>
    </div>
  </div>
</div>
<?php mysqli_close($conexion);?>