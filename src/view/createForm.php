<?php

$titreValue= key_exists($chansons::TITRE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::TITRE_REF] : "";
$artisteValue= key_exists($chansons::ARTISTE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ARTISTE_REF] : "";
$albumValue= key_exists($chansons::ALBUM_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ALBUM_REF] :"";
$styleValue= key_exists($chansons::STYLE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::STYLE_REF] : "";
$anneeValue= key_exists($chansons::ANNEE_REF,$chansons->getData()) ? $chansons->getData()[$chansons::ANNEE_REF] :"";

$titreError= key_exists($chansons::TITRE_REF,$chansons->getError()) ? $chansons->getError()[$chansons::TITRE_REF] : "";
$artisteError= key_exists($chansons::ARTISTE_REF,$chansons->getError()) ? $chansons->getError()[$chansons::ARTISTE_REF] : "";
$albumError= key_exists($chansons::ALBUM_REF,$chansons->getError()) ? $chansons->getError()[$chansons::ALBUM_REF] : "";
$styleError= key_exists($chansons::STYLE_REF,$chansons->getError()) ? $chansons->getError()[$chansons::STYLE_REF] : "";
$anneeError= key_exists($chansons::ANNEE_REF,$chansons->getError()) ? $chansons->getError()[$chansons::ANNEE_REF] : "";


$form='<form method="POST" action="'.$this->router->getCarSaveUrl().'">
  <div class="form-input">
    <p>'. $titreError .'</p>
    <label>Titre<input type="text" name="'.$chansons::NAME_REF.'"  value="'.$titreValue.'"></label>
  <div>
  <div class="form-input">
    <p>'. $artisteError .'</p>
    <label>Artiste<input type="text" name="'.$chansons::ARTISTE_REF.'" placeholder="entrer son espéce" value="'.  $artisteValue.'"></label>
  <div>
  <div class="form-input">
    <p>'. $albumError .'</p>
    <label>Album<input type="text" name="'.$chansons::ALBUM_REF.'"  value="'.$albumValue.'"></label>
  <div>
  <div class="form-input">
    <p>'. $StyleError .'</p>
    <label>Style<input type="text" name="'.$chansons::STYLE_REF.'" placeholder="entrer son espéce" value="'.  $styleValue.'"></label>
  <div>
  <div class="form-input">
  <p>'. $anneeError .'</p>
    <label>annee<input type="text" name="'.$chansons::ANNEE_REF.'" placeholder="entrer son annee" value="'.  $anneeValue.'"></label>
  <div>
  <button type="submit">Ajouter une nouvelle chanson</button>
</form>';
