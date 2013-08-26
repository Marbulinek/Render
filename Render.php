<?php
/**
 * TRIEDA: Render.php
 * AUTOR: Lukas Caniga
 * KONTAKT: lukas.caniga(at)gmail.com
 *          http://marbulinek.cekuj.net
 * 
 * LICENCIA: Túto triedu môžete používať, avšak bez MODIFIKÁCIE zdrojového kódu    
 */ 
Class Render
{
  private $__link;
  private $__baza;
  private $__priecinokStranok;
  private $__strankaNenajdena;
  
  function __construct()
  {
    $this->__link = array();
    // DEFAULTS
    $this->__baza = "page";   // defaultne nastavenie bazy
    $this->__priecinokStranok = "stranky/";
    $this->__strankaNenajdena = "chyba";
  }
  
  /**
   * Metóda makeSEO vytvorí seo odkaz z názvu
   */     
  private function vytvorSEO($paOdkaz)
  {
     $paOdkaz = stripslashes($paOdkaz);
     $paOdkaz = str_replace(
       explode(',','á,ä,č,ď,é,ě,ë,í,ĺ,ľ,ň,ó,ö,ô,ř,š,ť,ú,ů,ü,ý,ž,Á,Ä,Č,Ď,É,Ě,Ë,Í,Ĺ,Ľ,Ň,Ó,Ö,Ô,Ř,Š,Ť,Ú,Ů,Ü,Ý,Ž, '),
       explode(',','a,a,c,d,e,e,e,i,l,l,n,o,o,o,r,s,t,u,u,u,y,z,a,a,c,d,e,e,e,i,l,l,n,o,o,o,r,s,t,u,u,u,y,z,-'),
     $paOdkaz);
     $paOdkaz = strtolower($paOdkaz);
     $paOdkaz = preg_replace('/[^-a-z0-9]/','-',$paOdkaz);
     $paOdkaz = preg_replace('/-+/','-',$paOdkaz);
     $paOdkaz = trim($paOdkaz,'-');
     
     return $paOdkaz;
  }
  
  /**
   * Metóda nastavBazu nastaví bázu metódy $_GET, pod akou sa dané stránky volajú
   */     
  public function nastavBazu($paBaza)
  {
    $this->__baza = $paBaza;
  }

  /**
   * Metóda nastavPriecinokStranok nastaví cielový priečinok zo stránkami
   */     
  public function nastavPriecinokStranok($paPriecinok)
  {
    $poslednyZnak = substr($paPriecinok, -1);
    $this->__priecinokStranok = ($poslednyZnak != "/")?$paPriecinok."/":$paPriecinok; 
  }
  
  /**
   * Metóda nastavStrankuChyby nastaví chybovú stránku   
   */  
  public function nastavStrankuChyby($paStranka)
  {
    $this->__strankaNenajdena = $paStranka; 
  }
  
  /**
   * Metóda vytvorLink vytvorí pole odkazov, ktoré sa neskôr budú generovať
   */ 
  public function vytvorLink($paNazov)
  {
       $odkaz = $this->vytvorSEO($paNazov);
       $this->__link[$odkaz] = $paNazov;
  }
  
  /**
   * Metóda renderNavigator vytvorí klasické menu s bázou, teda odkazom v tvare '?page=about-us'
   * @param paHighlight - ak si prajem zvyraznit aktualnu polozku menu -> ponecham renderNavigation(), ak nechcem zvyraznovat
   * dam renderNavigation(false);      
   */     
  public function renderNavigator($paHighlight = true)
  {
    echo "<ul>";
    foreach($this->__link as $odkaz => $nazov)
    {
      if(isSet($_GET[$this->__baza]))
      {
        if($_GET[$this->__baza] == $odkaz)
        {
          $aktivneCSS = ($paHighlight==true)?"class='aktivne'":'';
          echo "<li><a href='?".$this->__baza."=".$odkaz."' $aktivneCSS>".$nazov."</a></li>";
        }else{
          echo "<li><a href='?".$this->__baza."=".$odkaz."'>".$nazov."</a></li>";
        }
      }else{
         echo "<li><a href='?".$this->__baza."=".$odkaz."'>".$nazov."</a></li>"; 
      }
    }
    echo "</ul>";
  }
  
  /**
   * Metóda renderSEONavigator vytvorí menu s user-friendly odkazmi    
   */     
  public function renderSEONavigator()
  {
    echo "<ul>";
    foreach($this->__link as $odkaz => $nazov)
    {
      if(isSet($_GET[$this->__baza]) && ($_GET[$this->__baza] == $odkaz))
      {
        echo "<li><a href='".$odkaz."' class='aktivne'>".$nazov."</a></li>";
      }else{
        echo "<li><a href='".$odkaz."'>".$nazov."</a></li>";
      }
    }
    echo "</ul>";
  }
  
  /**
   * Metóda renderMenu automatizuje dosadzovanie obsahu stránok do webovej prezentácie  
   */  
  public function renderMenu()
  {
    if(isSet($_GET[$this->__baza]))
    {
      $adresa = trim($_GET[$this->__baza]);
      if(file_exists($this->__priecinokStranok.$adresa.".php"))
      {
        include $this->__priecinokStranok.$adresa.".php";
      }else{
        include $this->__priecinokStranok.$this->__strankaNenajdena.".php";
      }                       
    }else{
      $tempLinky = array_values($this->__link);
      include $this->__priecinokStranok."/".$this->vytvorSEO($tempLinky[0]).".php";
    } 
  }

}


/*
  Priklad pouzitia
   
  //inicializacia
  include_once "core/Render.php";
  $Render = new Render();
  
  //inicializacia  
  $Render->nastavBazu("page");
  $Render->nastavPriecinokStranok("stranky");
  $Render->nastavStrankuChyby("chyba");
  
  //vygenerujem linky stranky
  $Render->vytvorLink("O jídelně");
  $Render->vytvorLink("Provozní řád");
  $Render->vytvorLink("Ceník stravování");
  $Render->vytvorLink("Jídelníček");
  $Render->vytvorLink("Kontakt");
  
  //vygenerujem navigator  A)
  $Render->renderNavigator();
  
  //ALEBO PRE PODPORU .HTACCESS (napr. 'http://example.sk/o-nas') B) 
  $Render->renderSEONavigator();
  
  //vygenerujem menu
  $Render->renderMenu();
  
  //uistite sa, ze mate vytvoreny priecinok stranky a vnom subory (napr. chyba.php, domov.php, atd... atd...)
*/

?>