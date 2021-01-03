<?php
if ($_SESSION["profile"] != "Admin") {
    ?>
    <script>
        window.location = "401";
    </script>
    <?php
    return;
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            User management
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUser">
                    Aggiungi Utente
                </button>
            </div>
            <div class="box-body">
                <table class="table-hover table table-bordered table-striped dt-responsive usersTable">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Nome e Cognome</th>
                        <th>Area Amministrativa</th>
                        <th>Foto Profilo</th>
                        <th>Profilo</th>
                        <th>Ruolo</th>
                        <th>Status</th>
                        <th>Ultimo Accesso</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $item = null;
                    $value = null;
                    $users = ControllerUsers::ctrShowUsers($item, $value);
                    foreach ($users as $key => $value) {
                        if ($value["profile"] == "Admin") {
                            continue;
                        }
                        $area = ControllerAreas::ctrShowAreas("id", $value["idArea"]);
                        if ($area) {
                            echo '
                  <tr>
                    <td>' . ($key) . '</td>
                    <td>' . $value["name"] . '</td>
                    <td>' . $area["name"] . '</td>';
                        } else {
                            echo '
                  <tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $value["name"] . '</td>
                    <td>Non appartiene a nessuna Area</td>';
                        }
                        if ($value["photo"] != "") {
                            echo '<td><img src="' . $value["photo"] . '" class="img-thumbnail" width="40px"></td>';
                        } else {
                            echo '<td><img src="views/img/users/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
                        }
                        if ($value["profile"] == null) {
                            echo '<td>Nessun Profilo</td>';
                        } else {
                            echo '<td>' . $value["profile"] . '</td>';
                        }
                        if ($value["responsabile"] == 1) {
                            echo '<td><button class="btn btn-success btnResponsible btn-xs" userId="' . $value["id"] . '" userResponsible="0">Responsabile</button></td>';
                        } else {
                            echo '<td><button class="btn btn-danger btnResponsible btn-xs" userId="' . $value["id"] . '" userResponsible="1">Non Responsabile</button></td>';
                        }
                        if ($value["status"] != 0) {
                            echo '<td><button class="btn btn-success btnActivate btn-xs" userId="' . $value["id"] . '" userStatus="0">Attivo</button></td>';
                        } else {
                            echo '<td><button class="btn btn-danger btnActivate btn-xs" userId="' . $value["id"] . '" userStatus="1">Inattivo</button></td>';
                        }
                        echo '<td>' . $value["lastLogin"] . '</td>
                    <td>
                      <div class="btn-group">                    
                        <button class="btn btn-warning btnEditUser" idUser="' . $value["id"] . '" data-toggle="modal" data-target="#editUser"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnDeleteUser" userId="' . $value["id"] . '" username="' . $value["user"] . '" userPhoto="' . $value["photo"] . '"><i class="fa fa-times"></i></button>
                      </div>  
                    </td>
                  </tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<!--=====================================
=            module add user            =
======================================-->
<!-- Modal -->
<div id="addUser" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="POST" enctype="multipart/form-data">
                <!--=====================================
                HEADER
                ======================================-->
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aggiungi Utente</h4>
                </div>
                <!--=====================================
                BODY
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!--Input name -->
                        <div style="font-size: large">Seleziona Nome e Cognome</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input class="form-control input-lg" type="text" name="newName"
                                       placeholder="Nome e Cognome" required>
                            </div>
                        </div>
                        <!-- input username -->
                        <div style="font-size: large">Seleziona Username</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input class="form-control input-lg" type="text" id="newUser" name="newUser"
                                       placeholder="Username" required>
                            </div>
                        </div>
                        <!-- input password -->
                        <div style="font-size: large">Seleziona Password</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input class="form-control input-lg" type="password" name="newPasswd"
                                       placeholder="Password" required>
                            </div>
                        </div>
                        <!-- input profile -->
                        <div style="font-size: large">Seleziona Profilo</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <select class="form-control input-lg" name="newProfile" required>
                                    <option disabled selected>Seleziona Profilo</option>
                                    <option value="Amministratore">Amministratore Generale</option>
                                    <option value="Responsabile Area">Responsabile Area</option>
                                    <option value="Dipendente">Dipendente</option>
                                </select>
                            </div>
                        </div>
                        <!-- input area -->
                        <div style="font-size: large">Seleziona Area Amministrativa</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                <select class="form-control input-lg" name="newArea" required>
                                    <option disabled selected>Seleziona Area</option>
                                    <?php
                                    $item = null;
                                    $value1 = null;
                                    $areas = ControllerAreas::ctrShowAreas($item, $value1);
                                    foreach ($areas as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Uploading image -->
                        <div class="form-group">
                            <div class="panel">Carica Immagine</div>
                            <input class="newPics" type="file" name="newPhoto">
                            <p class="help-block">Max dim. 2Mb</p>
                            <img class="thumbnail preview" src="views/img/users/default/anonymous.png" width="100px">
                        </div>
                    </div>
                </div>
                <!--=====================================
                FOOTER
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                    <button type="submit" formenctype="multipart/form-data" class="btn btn-primary">Salva</button>
                </div>
                <?php
                $createUser = new ControllerUsers();
                $createUser->ctrCreateUser();
                ?>
            </form>
        </div>
    </div>
</div>
<!--=====================================
=            module edit user            =
======================================-->
<!-- Modal -->
<div id="editUser" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="POST" enctype="multipart/form-data">
                <!--=====================================
                HEADER
                ======================================-->
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit user</h4>
                </div>
                <!--=====================================
                BODY
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!--Input name -->
                        <div style="font-size: large">Nome e Cognome</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input class="form-control input-lg" type="text" id="EditName" name="EditName"
                                       placeholder="Nome e Cognome" required>
                            </div>
                        </div>
                        <!-- input username -->
                        <div style="font-size: large">Username</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input class="form-control input-lg" type="text" id="EditUser" name="EditUser"
                                       placeholder="Edit username" readonly>
                            </div>
                        </div>
                        <!-- input password -->
                        <div style="font-size: large">Password</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input class="form-control input-lg" type="password" name="EditPasswd"
                                       placeholder="New password">
                                <input type="hidden" name="currentPasswd" id="currentPasswd">
                            </div>
                        </div>
                        <!-- input profile -->
                        <div style="font-size: large">Profilo</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <select class="form-control input-lg" name="EditProfile" id="EditProfile">
                                    <option disabled>Seleziona Profilo</option>
                                    <option value="Amministratore">Amministratore Generale</option>
                                    <option value="Responsabile Area">Responsabile Area</option>
                                    <option value="Dipendente">Dipendente</option>
                                </select>
                            </div>
                        </div>
                        <!-- input area -->
                        <div style="font-size: large">Area Amministrativa</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                <select class="form-control input-lg" id="editArea" name="editArea">
                                    <option disabled selected>Seleziona Area</option>
                                    <?php
                                    $item = null;
                                    $value1 = null;
                                    $areas = ControllerAreas::ctrShowAreas($item, $value1);
                                    foreach ($areas as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                        <!-- Uploading image -->
                        <div style="margin-top: 20px"></div>
                        <div style="font-size: large">Carica Immagina Profilo</div>
                        <div style="margin-top: 10px"></div>
                        <div class="form-group">
                            <input class="newPics" type="file" name="editPhoto">
                            <p class="help-block">Max dim 2Mb</p>
                            <img class="thumbnail preview" src="views/img/users/default/anonymous.png" alt=""
                                 width="100px">
                            <input type="hidden" name="currentPicture" id="currentPicture">
                        </div>
                    </div>
                </div>
                <!--=====================================
                FOOTER
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit User</button>
                </div>
                <?php
                $editUser = new ControllerUsers();
                $editUser->ctrEditUser();
                ?>
            </form>
        </div>
    </div>
</div>
<?php
$deleteUser = new ControllerUsers();
$deleteUser->ctrDeleteUser();
?> 