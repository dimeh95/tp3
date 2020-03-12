<?php

class Controller_home extends Controller
{

    public function action_home()
    {
        
        $m = Model::getModel(); // On récupère le modèle
        $data = [
            "nb" => $m->getNbNobelPrizes() //On récupère le nombre de prix nobels
        ];
        $this->render("home", $data);
    }

    public function action_default()
    {
        $this->action_home();
    }
}
