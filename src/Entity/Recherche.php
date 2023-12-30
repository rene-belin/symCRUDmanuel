<?php 
 
namespace App\Entity; 
 
class Recherche 
{ 
 
   private $nom; 
 
   public function getNom(): ?string 
   { 
       return $this->nom; 
   } 
 
   public function setNom(string $nom): self 
   { 
       $this->nom = $nom; 
 
       return $this; 
   } 
} 