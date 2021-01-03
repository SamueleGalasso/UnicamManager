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
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Gestione Targets Università
            </h1>
            <ol class="breadcrumb">
                <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTarget">
                        Aggiungi Target
                    </button>
                    </a>
                </div>
                <div class="box-body">
                    <table class="table-hover table table-bordered table-striped dt-responsive targetsUniversitaTable" width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Piano Annuale</th>
                            <th>Obiettivo</th>
                            <th>Target</th>
                            <th>Peso</th>
                            <th>Budget Target</th>
                            <th>% Completamento</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <!--=====================================
    =            module add target           =
    ======================================-->
    <!-- Modal -->
    <div id="addTarget" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="POST" enctype="multipart/form-data">
                    <!--=====================================
                    HEADER
                    ======================================-->
                    <div class="modal-header" style="background: #3c8dbc; color: #fff">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Aggiungi Target</h4>
                    </div>
                    <!--=====================================
                    BODY
                    ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <!--Input Title -->
                            <div style="font-size: large">Titolo</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-inbox"
                                                                       aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="newName" name="newName"
                                           placeholder="Aggiungi Nome" required>
                                </div>
                            </div>
                            <!-- input Objective -->
                            <div style="font-size: large">Obiettivo</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input-lg" id="newObjective" name="newObjective"
                                            required>
                                        <option id="newObjective" disabled selected>Seleziona Obiettivo</option>
                                        <?php
                                        $item = null;
                                        $value1 = null;
                                        $obj = ControllerObjectivesUniversita::ctrShowObjectivesUniversita($item, $value1);
                                        foreach ($obj as $key => $value) {
                                            echo '<option value="' . $value["id"] . '">' . $value["title"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- input description -->
                            <div style="font-size: large">Descrizione</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="newDescription"
                                           name="newDescription" placeholder="Descrizione" required>
                                </div>
                            </div>
                            <div style="font-size: large">Inserisci Peso</div>
                            <!-- INPUT PESO -->
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="col-xs-6" style="padding:0">
                                        <div class="input-group">
                                            <input type="number" class="form-control input-lg" id="newWeight"
                                                   name="newWeight" min="0" max="100" value="10" required>
                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--=====================================
                    FOOTER
                    ======================================-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Salva Target</button>
                    </div>
                </form>
                <?php
                $createTarget = new ControllerTargetUniversita();
                $createTarget->ctrCreateTargetUniversita();
                ?>
            </div>
        </div>
    </div>
    <!--=====================================
    =            module edit target         =
    ======================================-->
    <!-- Modal -->
    <div id="modalEditTargetUniversita" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="POST" enctype="multipart/form-data">
                    <!--=====================================
                    HEADER
                    ======================================-->
                    <div class="modal-header" style="background: #3c8dbc; color: #fff">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Target</h4>
                    </div>
                    <!--=====================================
                    BODY
                    ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <!--Input Title -->
                            <div style="font-size: large">Titolo</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-inbox"
                                                                       aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="editName" name="editName"
                                           placeholder="Aggiungi Titolo" required>
                                </div>
                            </div>
                            <!-- input Obj -->
                            <div style="font-size: large">Obiettivo</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input-lg" id="editObjective" name="editObjective"
                                            required>
                                        <?php
                                        $item = null;
                                        $value1 = null;
                                        $obj = ControllerObjectivesUniversita::ctrShowObjectivesUniversita($item, $value1);
                                        foreach ($obj as $key => $value) {
                                            echo '<option value="' . $value["id"] . '">' . $value["title"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- input description -->
                            <div style="font-size: large">Descrizione</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    <input class="form-control input-lg" type="text" id="editDescription"
                                           name="editDescription" placeholder="Descrizione" required>
                                </div>
                            </div>
                            <div style="font-size: large">Inserisci Peso</div>
                            <!-- INPUT PESO -->
                            <div class="form-group row">
                                <div class="col-xs-6">
                                    <div class="col-xs-6" style="padding:0">
                                        <div class="input-group">
                                            <input type="number" class="form-control input-lg" id="editWeight"
                                                   name="editWeight" min="0" max="100" value="10" required>
                                            <input type="hidden" id="id" name="id" required>
                                            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--=====================================
                    FOOTER
                    ======================================-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                        <button type="submit" class="btn btn-primary">Salva Target</button>
                    </div>
                    <?php
                    $editTarget = new ControllerTargetUniversita();
                    $editTarget->ctrEditTargetUniversita();
                    ?>
                </form>
            </div>
        </div>
    </div>
<?php
$deleteTarget = new ControllerTargetUniversita();
$deleteTarget->ctrDeleteTargetUniversita();
?>