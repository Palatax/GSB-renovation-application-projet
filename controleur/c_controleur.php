<?php

class Controleur
{
    public function render($vue, $variables = array())
    {
        extract($variables);

        include('vues/' . $vue . '.php');
    }
}