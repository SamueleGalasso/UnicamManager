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
            Gestione Piano Annuale
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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addPlans">Aggiungi Piano Annuale
                </button>
            </div>
            <div class="box-body">
                <table class="table-hover table table-bordered table-striped dt-responsive tables" width="100%">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Titolo</th>
                        <th>Budget</th>
                        <th>Anno</th>
                        <th>Descrizione</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $item = null;
                    $value = null;
                    $plans = ControllerPlans::ctrShowPlans($item, $value);
                    foreach ($plans as $key => $value) {
                        echo '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td class="text-uppercase">' . $value['title'] . '</td>
                          <td>' . $value['budget'] . ' €</td>
                          <td>' . $value['date'] . '</td>
                          <td>' . $value['description'] . '</td>
                          <td>
                            <div class="btn-group">                         
                              <button class="btn btn-primary btnViewPlan" style="width: 38px" idPlan="' . $value["id"] . '"><i class="fa fa-info"></i></button>
                              <button class="btn btn-danger btnDeletePlan" idPlan="' . $value["id"] . '"><i class="fa fa-times"></i></button>
                            </div>  
                          </td>
                        </tr>';
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
=            module add Plans            =
======================================-->
<!-- Modal -->
<div id="addPlans" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="POST">
                <div class="modal-header" style="background: #3c8dbc; color: #fff">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aggiungi Piano Annuale</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!--Input title -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input class="form-control input-lg" type="text" name="newTitle"
                                       placeholder="Aggiungi Titolo" required>
                            </div>
                        </div>
                        <!--Input description -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" name="newDescription"
                                       placeholder="Aggiungi Descrizione" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select multiple="multiple" style="width: 100%;" class="form-control"
                                        name="newAreasList[]" required>
                                    <?php
                                    $item = null;
                                    $value = null;
                                    $areas = ControllerAreas::ctrShowAreas($item, $value);
                                    foreach ($areas as $key => $value) {
                                        echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--Input budget -->
                        <div class="form-group">
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-money"
                                                                       aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="number" name="newBudget"
                                       placeholder="Aggiungi Budget" required>
                            </div>
                        </div>
                        <div id="budget_area">

                        </div>
                        <!--Input date -->
                        <div class="form-group">
                            <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"
                                                                       aria-hidden="true"></i></span>
                                <input class="form-control input-lg" type="text" name="newDate" value="2020"
                                       placeholder="Aggiungi Anno" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Salva Piano</button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php
$createPlan = new ControllerPlans();
$createPlan->ctrCreatePlan();
?>
<?php
$deletePlan = new ControllerPlans();
$deletePlan->ctrDeletePlan();
?>

<script>
    function createDiv(data) {
        const row = document.createElement("div");
        row.classList.add("row")
        const column1 = document.createElement("div");
        column1.classList.add("col-xs-6");
        const formGroup1 = document.createElement("div");
        formGroup1.classList.add("form-group");
        const input1 = document.createElement("input");
        input1.classList.add("form-control", "input-lg");
        input1.setAttribute("type", "text");
        input1.readOnly = true
        input1.value = data.name;
        column1.append(formGroup1);
        formGroup1.append(input1);

        const column2 = document.createElement("div");
        column2.classList.add("col-xs-6");
        const formGroup2 = document.createElement("div");
        formGroup2.classList.add("form-group");
        const inputGroup2 = document.createElement("div");
        inputGroup2.classList.add("input-group");
        const input2 = document.createElement("input");
        input2.classList.add("form-control", "input-lg");
        input2.type = "number"
        input2.required = true;
        input2.name = "area-" + data.value;
        input2.placeholder = "Budget"
        const span2 = document.createElement("span");
        span2.classList.add("input-group-addon");
        const i2 = document.createElement("i");
        i2.classList.add("fa", "fa-eur");
        column2.append(formGroup2);
        formGroup2.append(inputGroup2);
        inputGroup2.append(span2);
        span2.append(i2);
        inputGroup2.append(input2);

        row.append(column1);
        row.append(column2);

        return row;
    }

    function createRows(array) {
        const $area = $('#budget_area');
        $area.html("");
        for (let j = 0; j < array.length; j++) {
            $area.append(createDiv(array[j]));
        }
    }

    $(function () {
        const $select = $('select[name="newAreasList[]"]');
        $select.select2({
            placeholder: "   Seleziona Aree"
        });
        $select.change(function () {
            const array = $select.val().map(function (value) {
                return {name: $select.find("option[value=" + value + "]").html(), value}
            })
            createRows(array)
        })
        $('input[class="select2-search__field"]').css("width", "100%");
    })
</script>
