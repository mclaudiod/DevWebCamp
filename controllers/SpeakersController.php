<?php



    namespace Controllers;

    use Model\Speaker;
    use MVC\Router;
    use Intervention\Image\ImageManagerStatic as Image;
    use Classes\Pagination;

    class SpeakersController {
        public static function index(Router $router) {

            if(!isAdmin()) {
                header("Location: /login");
            }

            $currentPage = $_GET["page"] ?? 1;
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT) ?? 1;

            if(!$currentPage || $currentPage < 1) {
                header("Location: /admin/speakers?page=1");
            }

            $registriesPerPage = 10;
            
            $totalRegistries = Speaker::total();

            $pagination = new Pagination($currentPage, $registriesPerPage, $totalRegistries);

            if($pagination->totalPages() < $currentPage) {
                header("Location: /admin/speakers?page=1");
            }

            $speakers = Speaker::paginate($registriesPerPage, $pagination->offset());

            $router->render("admin/speakers/index", [
                "title" => "Speakers",
                "speakers" => $speakers,
                "pagination" => $pagination->pagination()
            ]);
        }

        public static function create(Router $router) {
            $alerts = [];

            if(!isAdmin()) {
                header("Location: /login");
            }

            $speaker = new Speaker;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(!isAdmin()) {
                    header("Location: /login");
                }

                // Find the image

                if(!empty($_FILES["img"]["tmp_name"])) {

                    // Creates the folder for the images

                    $imgFolder = "../public/img/speakers";

                    if(!is_dir($imgFolder)) {
                        mkdir($imgFolder, 0755, true);
                    }

                    // Creates the PNG and the WEBP version of the image

                    $imgPNG = Image::make($_FILES["img"]["tmp_name"])->fit(800, 800)->encode("png", 100);
                    $imgWEBP = Image::make($_FILES["img"]["tmp_name"])->fit(800, 800)->encode("webp", 100);

                    // Creates a random and unique name for the image

                    $imgName = md5(uniqid(rand(), true));

                    // Saves the name in POST so it can pass the validation

                    $_POST["img"] = $imgName;
                }

                // Changes the array of social networks into a string and fixes the strange slashes resulting from that

                $_POST["networks"] = json_encode($_POST["networks"], JSON_UNESCAPED_SLASHES);

                // Synchronices the data from the form with the fields in the database using the model

                $speaker->synchronize($_POST);

                // Validates that there is no necessary fields missing

                $alerts = $speaker->validate();

                if(empty($alerts)) {

                    // Saves the images

                    $imgPNG->save($imgFolder . "/" . $imgName . ".png");
                    $imgWEBP->save($imgFolder . "/" . $imgName . ".webp");

                    // Save in the DB

                    $result = $speaker->save();

                    if($result) {
                        header("Location: /admin/speakers");
                    }
                }
            }

            $router->render("admin/speakers/create", [
                "title" => "Add Speaker",
                "alerts" => $alerts,
                "speaker" => $speaker, 
                "networks" => json_decode($speaker->networks)
            ]);
        }

        public static function edit(Router $router) {
            $alerts = [];

            if(!isAdmin()) {
                header("Location: /login");
            }
            
            // Validate the id

            $id = $_GET["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if(!$id) {
                header("Location: /admin/speakers");
            }
            
            // Get speaker to edit

            $speaker = Speaker::find($id);

            if(!$speaker) {
                header("Location: /admin/speakers");
            }

            $speaker->currentImg = $speaker->img;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(!isAdmin()) {
                    header("Location: /login");
                }

                // Find the image

                if(!empty($_FILES["img"]["tmp_name"])) {

                    // Creates the folder for the images

                    $imgFolder = "../public/img/speakers";

                    if(!is_dir($imgFolder)) {
                        mkdir($imgFolder, 0755, true);
                    }

                    // Creates the PNG and the WEBP version of the image

                    $imgPNG = Image::make($_FILES["img"]["tmp_name"])->fit(800, 800)->encode("png", 100);
                    $imgWEBP = Image::make($_FILES["img"]["tmp_name"])->fit(800, 800)->encode("webp", 100);

                    // Creates a random and unique name for the image

                    $imgName = md5(uniqid(rand(), true));

                    // Saves the name in POST so it can pass the validation

                    $_POST["img"] = $imgName;
                } else {
                    $_POST["img"] = $speaker->currentImg;
                }

                // Changes the array of social networks into a string and fixes the strange slashes resulting from that

                $_POST["networks"] = json_encode($_POST["networks"], JSON_UNESCAPED_SLASHES);

                // Synchronices the data from the form with the fields in the database using the model

                $speaker->synchronize($_POST);

                // Validates that there is no necessary fields missing

                $alerts = $speaker->validate();

                if(empty($alerts)) {

                    if(isset($imgName)) {

                        // Saves the images

                        $imgPNG->save($imgFolder . "/" . $imgName . ".png");
                        $imgWEBP->save($imgFolder . "/" . $imgName . ".webp");
                    }

                    // Save in the DB

                    $result = $speaker->save();

                    if($result) {
                        header("Location: /admin/speakers");
                    }
                }
            }

            $router->render("admin/speakers/edit", [
                "title" => "Edit Speaker",
                "alerts" => $alerts,
                "speaker" => $speaker,
                "networks" => json_decode($speaker->networks)
            ]);
        }

        public static function delete() {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(!isAdmin()) {
                    header("Location: /login");
                }

                // Validate the id

                $id = $_POST["id"];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if(!$id) {
                    header("Location: /admin/speakers");
                }
                
                // Get speaker to delete
    
                $speaker = Speaker::find($id);
    
                if(!isset($speaker)) {
                    header("Location: /admin/speakers");
                }

                $result = $speaker->delete();

                if($result) {
                    header("Location: /admin/speakers");
                }
            }
        }
    }