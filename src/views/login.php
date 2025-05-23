<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../output.css" rel="stylesheet">
</head>
<body>
    <div class="h-screen flex items-center justify-center bg-gradient-to-r from-[#2c4b76] via-[#775e61] via-[#ac7349] to-[#de8824]">
        <form action="../script/validar.php" method="POST" class="flex flex-col gap-2.5 bg-white p-7 w-[450px] rounded-2xl font-sans shadow-lg">
          
          <div class="flex flex-col">
            <label class="text-[#151717] font-semibold">Correo</label>
          </div>

          <div class="border-[1.5px] border-[#ecedec] rounded-lg h-[50px] flex items-center pl-2.5 transition-all focus-within:border-blue-500">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><g data-name="Layer 3" id="Layer_3"><path d="M30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
              <input name="correo" placeholder="Ingresa tu correo" class="ml-2.5 rounded-lg border-none w-full h-full focus:outline-none" type="text">
          </div>
          
          <div class="flex flex-col">
            <label class="text-[#151717] font-semibold">Contraseña</label>
          </div>

          <div class="border-[1.5px] border-[#ecedec] rounded-lg h-[50px] flex items-center pl-2.5 transition-all focus-within:border-blue-500">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="-64 0 512 512"><path d="M336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="M304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>        
              <input name="contrasena" placeholder="Ingresa tu contraseña" class="ml-2.5 rounded-lg border-none w-full h-full focus:outline-none" type="password">
          </div>
          
          <div class="flex flex-row items-center gap-2.5 justify-between">
            
            <span class="text-sm ml-1 text-blue-500 font-medium cursor-pointer">¿Olvidaste tu contraseña?</span>
          </div>

          <?php
            // Si hay un mensaje de error, lo muestra
            $error_message = $error_message ?? '';
            if ($error_message != '') {
                echo '<div class="text-red-600">' . $error_message . '</div>';
            }
          ?>
      
          <button type="submit" class="mt-5 bg-[#151717] border-none text-white text-[15px] font-medium rounded-lg h-[50px] w-full cursor-pointer">
            Iniciar sesión
          </button>
      
          <p class="text-center text-black text-sm my-1">¿No tienes una cuenta? 
            <span class="text-blue-500 font-medium cursor-pointer">Regístrate</span></p>
      
        </form>
        
      </div>
      
</body>
</html>