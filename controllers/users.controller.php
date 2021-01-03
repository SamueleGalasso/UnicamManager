<?php

class ControllerUsers
{
    /*=============================================
    USER LOGIN
    =============================================*/

    static public function ctrUserLogin()
    {
        if (isset($_POST["loginUser"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["loginUser"]) &&
                preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["loginPass"])) {
                $encryptpass = crypt($_POST["loginPass"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $table = 'users';
                $item = 'user';
                $value = $_POST["loginUser"];
                $answer = UsersModel::MdlShowUsers($table, $item, $value);
                if (!$answer) {
                    echo '<br><div class="alert alert-danger">Username o password errata</div>';
                    return;
                }
                if (is_null($answer["profile"])) {
                    echo '<br><div class="alert alert-danger">Accesso Negato!</div>';
                    return;
                }

                if ($answer["user"] == $_POST["loginUser"] && $answer["password"] == $encryptpass) {
                    if ($answer["status"] == 1) {
                        $_SESSION["loggedIn"] = "ok";
                        $_SESSION["id"] = $answer["id"];
                        $_SESSION["name"] = $answer["name"];
                        $_SESSION["idArea"] = $answer["idArea"];
                        $_SESSION["user"] = $answer["user"];
                        $_SESSION["photo"] = $answer["photo"];
                        $_SESSION["profile"] = $answer["profile"];
                        /*=============================================
                        Register date to know last_login
                        =============================================*/
                        date_default_timezone_set("Europe/Rome");
                        $date = date('Y-m-d');
                        $hour = date('H:i:s');
                        $actualDate = $date . ' ' . $hour;
                        $item1 = "lastLogin";
                        $value1 = $actualDate;
                        $item2 = "id";
                        $value2 = $answer["id"];
                        $lastLogin = UsersModel::mdlUpdateUser($table, $item1, $value1, $item2, $value2);
                        if ($lastLogin == "ok") {
                            echo '<script>
								window.location = "home";
							</script>';
                        }
                    } else {
                        echo '<br><div class="alert alert-danger">Utente inattivo!</div>';
                    }
                } else {
                    echo '<br><div class="alert alert-danger">Username o password errata</div>';
                }
            }
        }
    }

    /*=============================================
    CREATE USER
    =============================================*/
    static public function ctrCreateUser()
    {
        if (isset($_POST["newUser"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newName"]) &&
                preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newUser"]) &&
                preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["newPasswd"])) {
                /*=============================================
                VALIDATE IMAGE
                =============================================*/
                $photo = "";
                if (isset($_FILES["newPhoto"]["tmp_name"])) {
                    list($width, $height) = getimagesize($_FILES["newPhoto"]["tmp_name"]);
                    $newWidth = 500;
                    $newHeight = 500;
                    /*=============================================
                    Let's create the folder for each user
                    =============================================*/
                    $folder = "views/img/users/" . $_POST["newUser"];
                    mkdir($folder, 0755);
                    /*=============================================
                    PHP functions depending on the image
                    =============================================*/
                    if ($_FILES["newPhoto"]["type"] == "image/jpeg") {
                        $randomNumber = mt_rand(100, 999);
                        $photo = "views/img/users/" . $_POST["newUser"] . "/" . $randomNumber . ".jpg";
                        $srcImage = imagecreatefromjpeg($_FILES["newPhoto"]["tmp_name"]);
                        $destination = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagejpeg($destination, $photo);
                    }
                    if ($_FILES["newPhoto"]["type"] == "image/png") {
                        $randomNumber = mt_rand(100, 999);
                        $photo = "views/img/users/" . $_POST["newUser"] . "/" . $randomNumber . ".png";
                        $srcImage = imagecreatefrompng($_FILES["newPhoto"]["tmp_name"]);
                        $destination = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagepng($destination, $photo);
                    }
                }
                $table = 'users';
                $encryptpass = crypt($_POST["newPasswd"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $data = array('name' => $_POST["newName"],
                    'user' => $_POST["newUser"],
                    'password' => $encryptpass,
                    'profile' => $_POST["newProfile"],
                    'photo' => $photo,
                    'idArea' => $_POST["newArea"]);
                if (is_null($data["profile"]) || is_null($data["idArea"])) {
                    echo '<script>
					swal({
						type: "error",
						title: "Compila tutti i campi!",
						showConfirmButton: true,
						confirmButtonText: "Close"
						}).then(function(result){
							if(result.value){
								window.location = "users";
							}
						});
				</script>';
                    return;
                }
                $answer = UsersModel::mdlAddUser($table, $data);
                if ($answer == 'ok') {
                    echo '<script>
						swal({
							type: "success",
							title: "Utente aggiunto con successo!",
							showConfirmButton: true,
							confirmButtonText: "Chiudi"
						}).then(function(result){
							if(result.value){
								window.location = "users";
							}
						});
						</script>';
                }
            } else {
                echo '<script>
					swal({
						type: "error",
						title: "Non sono ammessi caratteri speciali o form vuoti!",
						showConfirmButton: true,
						confirmButtonText: "Close"
						}).then(function(result){
							if(result.value){
								window.location = "users";
							}
						});
				</script>';
            }
        }
    }

    /*=============================================
    SHOW USER
    =============================================*/

    static public function ctrShowUsers($item, $value)
    {
        $table = "users";
        if ($value == null && $item != null) {
            return null;
        } else {
            $answer = UsersModel::MdlShowUsers($table, $item, $value);
        }
        return $answer;
    }

    /*=============================================
    EDIT USER
    =============================================*/

    static public function ctrEditUser()
    {
        if (isset($_POST["EditUser"])) {
            if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\a-zA-Z0-9]/', $_POST["EditName"])) {
                /*=============================================
                VALIDATE IMAGE
                =============================================*/
                $photo = $_POST["currentPicture"];
                if (isset($_FILES["editPhoto"]["tmp_name"]) && !empty($_FILES["editPhoto"]["tmp_name"])) {
                    list($width, $height) = getimagesize($_FILES["editPhoto"]["tmp_name"]);
                    $newWidth = 500;
                    $newHeight = 500;
                    /*=============================================
                    Let's create the folder for each user
                    =============================================*/
                    $folder = "views/img/users/" . $_POST["EditUser"];
                    /*=============================================
                    we ask first if there's an existing image in the database
                    =============================================*/
                    if (!empty($_POST["currentPicture"])) {
                        unlink($_POST["currentPicture"]);
                    } else {
                        mkdir($folder, 0755);
                    }
                    /*=============================================
                    PHP functions depending on the image
                    =============================================*/
                    if ($_FILES["editPhoto"]["type"] == "image/jpeg") {
                        /*We save the image in the folder*/
                        $randomNumber = mt_rand(100, 999);
                        $photo = "views/img/users/" . $_POST["EditUser"] . "/" . $randomNumber . ".jpg";
                        $srcImage = imagecreatefromjpeg($_FILES["editPhoto"]["tmp_name"]);
                        $destination = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagejpeg($destination, $photo);
                    }
                    if ($_FILES["editPhoto"]["type"] == "image/png") {
                        /*We save the image in the folder*/
                        $randomNumber = mt_rand(100, 999);
                        $photo = "views/img/users/" . $_POST["EditUser"] . "/" . $randomNumber . ".png";
                        $srcImage = imagecreatefrompng($_FILES["editPhoto"]["tmp_name"]);
                        $destination = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagepng($destination, $photo);
                    }
                }
                $table = 'users';
                if ($_POST["EditPasswd"] != "") {
                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["EditPasswd"])) {
                        $encryptpass = crypt($_POST["EditPasswd"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                    } else {
                        echo '<script>
							swal({
								type: "error",
								title: "Non sono ammessi caratteri speciali o form vuotiii!",
								showConfirmButton: true,
								confirmButtonText: "Close"
								}).then(function(result){	
									if (result.value) {
										window.location = "users";
									}
								});
						</script>';
                    }
                } else {
                    $encryptpass = $_POST["currentPasswd"];
                }
                $data = array('name' => $_POST["EditName"],
                    'user' => $_POST["EditUser"],
                    'password' => $encryptpass,
                    'profile' => $_POST["EditProfile"],
                    'idArea' => $_POST["editArea"],
                    'photo' => $photo);
                $answer = UsersModel::mdlEditUser($table, $data);
                if ($answer == 'ok') {
                    echo '<script>
						swal({
							type: "success",
							title: "User aggiornato con successo!",
							showConfirmButton: true,
							confirmButtonText: "Chiudi"
						 }).then(function(result){
							if (result.value) {
								window.location = "users";
							}
						});
					</script>';
                } else {
                    echo '<script>
						swal({
							type: "error",
							title: "Non sono ammessi caratteri speciali o form vuoti!",
							showConfirmButton: true,
							confirmButtonText: "Chiudi"
							 }).then(function(result){	
								if (result.value) {
									window.location = "users";
								}
							});
					</script>';
                }
            }
        }
    }

    /*=============================================
    DELETE USER
    =============================================*/

    static public function ctrDeleteUser()
    {
        if (isset($_GET["userId"])) {
            $table = "users";
            $data = $_GET["userId"];
            if ($_GET["userPhoto"] != "") {
                unlink($_GET["userPhoto"]);
                rmdir('views/img/users/' . $_GET["username"]);
            }
            $answer = UsersModel::mdlDeleteUser($table, $data);
            if ($answer == "ok") {
                echo '<script>
				swal({
					  type: "success",
					  title: "Utente eliminato con successo!",
					  showConfirmButton: true,
					  confirmButtonText: "Chiudi"
					  }).then(function(result){
						if (result.value) {
						window.location = "users";
						}
					})
				</script>';
            }
        }
    }
}

