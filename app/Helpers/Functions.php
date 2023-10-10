<?php

function setAvailability($value, $value2){
    if (trim($value) == "" and trim($value2) == ""){
        return "Disponible";
    }
    else {
        return "Ocupado";
    }
}