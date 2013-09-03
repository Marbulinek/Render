<?php
/**
 * TRIEDA: Link.php
 * AUTOR: Lukas Caniga
 * KONTAKT: lukas.caniga(at)gmail.com
 *          http://marbulinek.cekuj.net
 * 
 * LICENCIA: Túto triedu môžete používať, avšak bez MODIFIKÁCIE zdrojového kódu
 * VERZIA: 1.0
 * DÁTUM_VYDANIA: 3.9.2013   
 *  
 * Táto trieda slúži ako ADT pre triedu Render.php
 * Trieda Link.php musí byť v rovnakom priečinku ako Render.php       
 */ 
Class Link
{
  /**
   *  Uchováva názov odkazu
   */     
  private $__nazov;
  
  /**
   *  Uchováva cestu odkazu  
   */  
  private $__link;                 
    
  function __construct($paNazov, $paLink)
  {
    $this->__nazov = $paNazov;
    $this->__link = $paLink;
  }
  
  /**
   *  Nastavenie nazvu odkazu
   */     
  public function nastavNazov($paNazov)
  {
    $this->__nazov = $paNazov; 
  }
  
  /**
   *  Nastavenie cesty odkazu
   */     
  public function nastavLink($paLink)
  {
    $this->__link = $paLink;
  }
  
  /**
   *  Vracia nazov odkazu
   */     
  public function dajNazov()
  {
    return $this->__nazov;
  }
  
  /**
   *  Vracia cestu odkazu
   */     
  public function dajLink()
  {
    return $this->__link;
  }
}
?>