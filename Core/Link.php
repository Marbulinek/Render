<?php
/**
 * Class: Link.php
 * AUTOR: Lukas Caniga
 * CONTACT: lukas.caniga(at)gmail.com
 *          http://marbulinek.cekuj.net
 * 
 * VERSION: 1.1
 * DATE: 3.9.2013   
 */ 
Class Link
{
  /**
   *  name of the link
   */     
  private $_name;
  
  /**
   *  path of the link  
   */  
  private $__link;                 
    
  function __construct($name, $link)
  {
    $this->_name = $name;
    $this->__link = $link;
  }
  
  /**
   *  setter for name
   */     
  public function SetName($name)
  {
    $this->_name = $name; 
  }
  
  /**
   *  setter for path
   */     
  public function SetLink($link)
  {
    $this->__link = $link;
  }
  
  /**
   *  return name
   */     
  public function GetName()
  {
    return $this->_name;
  }
  
  /**
   *  return path
   */     
  public function GetLink()
  {
    return $this->__link;
  }
}
?>