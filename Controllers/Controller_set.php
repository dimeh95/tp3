<?php

class Controller_set extends Controller
{

    public function action_form_add()
    {

        $m = Model::getModel();
        $data = [
            "categories" => $m->getCategories()
        ];
        $this->render("form_add", $data);
    }
    
    public function action_default()
    {

        $this->action_form_add();
    }

    public function action_add()
    {

        $ajout = false;

        //Test si les informations nécessaires sont fournies
        if (isset($_POST["name"]) and !preg_match("#^ *$#", $_POST["name"])
            and isset($_POST["category"]) and !preg_match("#^ *$#", $_POST["category"])
            and isset($_POST["year"]) and preg_match("#^[12]\d{3}$#", $_POST["year"])) {
                // On vérifie que la catégorie est une des catégories possibles
                $m = Model::getModel();
            if (in_array($_POST["category"], $m->getCategories())) {
                // Préparation du tableau infos
                $infos = [];
                $noms = ['year', 'category', 'name', 'birthdate','birthplace', 'county', 'motivation'];
                foreach ($noms as $v) {
                    if (isset($_POST[$v]) and !preg_match("#^ *$#", $_POST[$v])) {
                        $infos[$v] = $_POST[$v];
                    } else {
                        $infos[$v] = null;
                    }
                }

                $m = Model::getModel(); //Récupération du modèle
                $ajout = $m->addNobelPrize($infos); //Ajout du prix nobel dans la base
            }
        }
        
        //Préparation de $data pour l'affichage de la vue message
        $data = [
            "title" => "Adding a Nobel Prize"
        ];
        if ($ajout) {
            $data["message"] = "The Nobel Prize has beed added in the database.";
        } else {
            $data["message"] = "There was a problem! The Nobel Prize could not be added to the database.";
        }
        $this->render("message", $data);
    }


    public function action_remove()
    {


        
        
        if (isset($_GET["id"]) and preg_match("#^[1-9]\d*$#", $_GET["id"])) {
            $id = $_GET["id"];
            
            $m = Model::getModel();
            $suppression = $m->removeNobelPrize($id);
            if ($suppression) {
                $message = "The Nobel Prize has been removed.";
            } else {
                $message = "There is no Nobel Prize with id " . $id . "!";
            }
        } else {
            $message = "There is no id in the URL!";
        }

        $data = [
            "title" => "Removing a Nobel Prize.",
            "message" => $message
        ];
        $this->render("message", $data);
    }

    public function action_form_update()
    {
        $in_database = false;
        if (isset($_GET["id"]) and preg_match("#^[1-9]\d*$#", $_GET["id"])) {
            $m = Model::getModel();
            $in_database = $m->isInDataBase($_GET["id"]);
        }

        if ($in_database) {
            $informations = $m->getNobelPrizeInformations($_GET["id"]); //Récupération des informations du prix nobel

            //Préparation de $data
            $data = [];
            foreach ($informations as $c => $v) {
                if (is_null($v)) {
                    $data[$c] = "";
                } else {
                    $data[$c] = $v;
                }
            }
            $data["categories"] = $m->getCategories();
            $this->render("form_update", $data);
        } else {
            $this->action_error("There is no Nobel Prize with such ID!!! It cannot be updated!!!");
        }
    }

    public function action_update()
    {

        $in_database = false;
        if (isset($_POST["id"]) and preg_match("#^[1-9]\d*$#", $_POST["id"])
           and isset($_POST["name"]) and !preg_match("#^_*$#", $_POST["name"])
           and isset($_POST["category"]) and !preg_match("#^_*$#", $_POST["category"])
           and isset($_POST["year"]) and preg_match("#^[12]\d{3}$#", $_POST["year"])) {
            $m = Model::getModel();
            $c_in_database = in_array($_POST["category"], $m->getCategories());
            $in_database = $c_in_database ? $m->isInDataBase($_POST["id"]) : false;
        }

        if ($in_database) {
            //Préparation $infos pour la mise à jour des informations du prix nobel
            $infos = [];
            $noms = ['id','year', 'category', 'name', 'birthdate','birthplace', 'county', 'motivation'];
            foreach ($noms as $v) {
                if (isset($_POST[$v]) and !preg_match("#^ *$#", $_POST[$v])) {
                    $infos[$v] = $_POST[$v];
                } else {
                    $infos[$v] = null;
                }
            }
            $m->updateNobelPrize($infos);
            $message = "The informations of the Nobel Prize have been updated.";
        } else {
            $message = "There is no information to update.";
        }
        $data = [
            "title" => "Updating the Nobel Prize informations",
            "message" => $message
        ];
        $this->render("message", $data);
    }
}
