<?php

require_once "controllers/template.controller.php";
require_once "controllers/users.controller.php";
require_once "controllers/plans.controller.php";
require_once "controllers/objectives.controller.php";
require_once "controllers/objectivesUniversita.controller.php";
require_once "controllers/areas.controller.php";
require_once "controllers/targets.controller.php";
require_once "controllers/targetsUniversita.controller.php";
require_once "controllers/indicators.controller.php";
require_once "controllers/indicatorsUniversita.controller.php";

require_once "models/indicators.model.php";
require_once "models/users.model.php";
require_once "models/plans.model.php";
require_once "models/objectives.model.php";
require_once "models/objectivesUniversita.model.php";
require_once "models/areas.model.php";
require_once "models/targets.model.php";
require_once "models/targetsUniversita.model.php";
require_once "models/indicatorsUniversita.model.php";

$template = new ControllerTemplate();
$template->ctrTemplate();