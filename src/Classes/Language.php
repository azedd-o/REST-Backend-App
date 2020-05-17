<?php

namespace App\Classes;

class Language 
{

  private $name;
  private $listRepos  = array();
  private $nbRepos;


  
  function getName() 
  {
    return $this->name;
  }
  
  function setName($name) 
  {
    $this->name = $name;
  }
  
  function getListRepos() 
  {
    return $this->listRepos;
  }
  
  function setListRepos($listRepos) 
  {
    $this->listRepos = $listRepos;
  }
  
  function getNbRepos() 
  {
    return count($this->listRepos);
  }
  
  function setNbRepos($nbRepos) 
  {
    $this->nbRepos = $nbRepos;
  }
  
  
}
?>
