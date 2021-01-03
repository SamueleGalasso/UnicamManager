<?php
if ($_SESSION["profile"] != "Admin") {
    if ($_SESSION["profile"] != "Amministratore") {
        ?>
        <script>
            window.location = "401";
        </script>
        <?php
        return;
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestione Aree Amministrative
        </h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addArea">Aggiungi Area
                    Amministrativa
                </button>
            </div>
            <div class="box-body">
                <table class="table-hover table table-bordered table-striped dt-responsive tables" width="100%">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Nome</th>
                        <th>Responsabile</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $item = null;
                    $value = null;
                    $areas = ControllerAreas::ctrShowAreas($item, $value);
                    foreach ($areas as $key => $value) {
                        $item = "id";
                        $user = controllerUsers::ctrShowUsers($item, $value["idResponsabile"]);
                        $idArea = $value["id"];
                        if ($user != null) {
                            echo '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td class="text-uppercase">' . $value['name'] . '</td>
                          <td>' . $user['name'] . '</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-warning btnEditArea" idArea="' . $idArea . '" data-toggle="modal" data-target="#addArea1"><i class="fa fa-pencil"></i></button>
                              <button class="btn btn-danger btnDeleteArea" idArea="' . $idArea . '"><i class="fa fa-times"></i></button>
                            </div>  
                          </td>
                        </tr>';
                        } else {
                            echo '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td class="text-uppercase">' . $value['name'] . '</td>
                          <td>Nessun Responsabile</td>
                          <td>' . $value['budget'] . ' €</td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-warning btnEditArea" idArea="' . $idArea . '" data-toggle="modal" data-target="#addArea1"><i class="fa fa-pencil"></i></button>
                              <button class="btn btn-danger btnDeleteArea" idArea="' . $idArea . '"><i class="fa fa-times"></i></button>
                            </div>  
                          </td>
                        </tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!--=====================================
=            module add Area            =
======================================-->
<!-- Modal -->
<div id="addArea" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="POST">
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aggiungi Area Amministrativa</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!--Input name -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input class="form-control input-lg" type="text" name="newName"
                                       placeholder="Aggiungi Nome" required>
                            </div>
                        </div>
                        <!-- input RESPONSABILE -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                <select class="form-control input-lg" name="newResponsabile">
                                    <?php
                                    echo '<option disabled selected>Seleziona Responsabile</option>';
                                    $item = null;
                                    $value = null;
                                    $users = ControllerUsers::ctrShowUsers($item, $value);
                                    foreach ($users as $key => $value) {
                                        if ($value["responsabile"] == 1)
                                            echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salva Area</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$createArea = new ControllerAreas();
$createArea->ctrCreateArea();
?>
<!-- Modal-->
<div id="addArea1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="POST">
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aggiorna Area Amministrativa</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- input RESPONSABILE -->
                        <div style="font-size: large">Seleziona Responsabile Area</div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                <select class="form-control input-lg" id="editResponsabile" name="editResponsabile">
                                    <?php
                                    $item = null;
                                    $value = null;
                                    $users = ControllerUsers::ctrShowUsers($item, $value);
                                    foreach ($users as $key => $value) {
                                        if ($value["responsabile"] == 1) {
                                            echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--Input name -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input class="form-control input-lg" type="text" name="editName" id="editName"
                                       placeholder="Aggiungi Nome" required>
                                <input type="hidden" id="idArea" name="idArea">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salva Area</button>
                </div>
                <?php
                $editArea = new ControllerAreas();
                $editArea->ctrEditArea();
                ?>
            </form>
        </div>
    </div>
</div>
<?php
$deleteArea = new ControllerAreas();
$deleteArea->ctrDeleteArea();
?>


