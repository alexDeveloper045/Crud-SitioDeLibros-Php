<?php
session_start();
    if ($_POST) {
        if ($_POST['usuario'] == 'alex04@gmail.com' && $_POST['contrasena'] == '00117908590') {
            /*con session le estamos diciendo que nos de el permiso donde esta la 
            variable session usuario, que en este caso esta en el archivo cabecera.php*/
            $_SESSION['usuario']='ok';
            $_SESSION['nombreUsuario']='alex04@gmail.com';
            header('location:inicio.php');
        }
    
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Administrador del sitio web</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  
              <div class="card">
                  <div class="card-header">
                      Login
                  </div>
                  <div class="card-body">
                    

                    <form method="POST">
                    <div class = "form-group">
                        <label>User</label>
                            <input type="email" class="form-control" name="usuario" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    </div>
                                        <div class="form-group">
                                    <label>Password</label>
                                <input type="password" class="form-control" name="contrasena" placeholder="Password">
                            </div>
                        <button type="submit" class="btn btn-primary">Enter to system</button>
                    </form>
                    
                    
                  </div>
                 
              </div>


              </div>
              
          </div>
      </div>
   
  </body>
</html>