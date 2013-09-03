<?php
include_once "Link.php";

/**
 * TRIEDA: Render.php
 * AUTOR: Lukas Caniga
 * KONTAKT: lukas.caniga(at)gmail.com
 *          http://marbulinek.cekuj.net
 * 
 * LICENCIA: Túto triedu môžete používať, avšak bez MODIFIKÁCIE zdrojového kódu 
 * VERZIA: 1.4
 * DÁTUM_VYDANIA: 3.9.2013     
 */ 
Class Render
{
  private $__baza;
  private $__priecinokStranok;
  private $__strankaNenajdena;
  private $__cssActive; 
  
  private $__zoznamOdkazov;
  
  function __construct()
  {
    //$__link = new Link();
    
    /**
     *  defaultne nastavenie bazy
     */     
    $this->__baza = "page";
    
    /**
     *  nastavenie priecinka, kde su pod-stranky umiestnene      
     */    
    $this->__priecinokStranok = "stranky";
    
    /**
     *  nazov stranky, ktora obsahuje chybovu hlasku    (napr. chyba.php, 404.php atd)
     *  klasicka 404 - page not found     
     */    
    $this->__strankaNenajdena = "chyba";
    
    /**
     *  CSS selektor pre nastavenie prave aktivneho odkazu
     */         
    $this->__cssActive = "aktivne";
    
    
    $this->__zoznamOdkazov = array();
  }
  
  /**
   * Metóda vytvorSEO vytvorí seo odkaz z názvu
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
   * Metóda nastavCSSAktivne nastavuje css selektor aktualneho odkazu
   */     
  public function nastavCSSAktivne($paSelektor)
  {
    $this->__cssActive = $paSelektor;
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
  public function vytvorLink($paNazov, $paLink = "")
  {
       if($paLink != "")
       {
         $tempLink = new Link($paNazov, $paLink);
         $this->__zoznamOdkazov[] = $tempLink;
       }else{
         $link = $this->vytvorSEO($paNazov);
         $tempLink = new Link($paNazov, $link);
         $this->__zoznamOdkazov[] = $tempLink;
       }
  }
  
  /**
   * Metóda renderNavigator vytvorí klasické menu s bázou, teda odkazom v tvare '?page=about-us'
   * @param paHighlight - ak si prajem zvyraznit aktualnu polozku menu -> ponecham renderNavigation(), ak nechcem zvyraznovat
   * dam renderNavigation(false);      
   */     
  public function renderNavigator($paHighlight = true)
  {
    echo "\n<ul>\n";
    foreach($this->__zoznamOdkazov as $odkaz)
    {
      if(isSet($_GET[$this->__baza]))
      {
        if($_GET[$this->__baza] == $odkaz->dajLink())
        {
          $aktivneCSS = ($paHighlight==true)?"class='".$this->__cssActive."'":'';
          echo "<li><a href='?".$this->__baza."=".$odkaz->dajLink()."' $aktivneCSS>".$odkaz->dajNazov()."</a></li>\n";
        }else{
          echo "<li><a href='?".$this->__baza."=".$odkaz->dajLink()."'>".$odkaz->dajNazov()."</a></li>\n";
        }
      }else{
         echo "<li><a href='?".$this->__baza."=".$odkaz->dajLink()."'>".$odkaz->dajNazov()."</a></li>\n"; 
      }
    }
    echo "</ul>\n";
  }
  
  /**
   * Metóda renderSEONavigator vytvorí menu s user-friendly odkazmi    
   */     
  public function renderSEONavigator($paHighlight = true)
  {
    echo "\n<ul>\n";
    foreach($this->__zoznamOdkazov as $odkaz)
    {
      if(isSet($_GET[$this->__baza]) && ($_GET[$this->__baza] == $odkaz->dajLink()))
      {
        $aktivneCSS = ($paHighlight==true)?"class='".$this->__cssActive."'":'';
        echo "<li><a href='/".$$odkaz->dajLink()."' $aktivneCSS>".$odkaz->dajNazov()."</a></li>\n";
      }else{
        echo "<li><a href='/".$odkaz->dajLink()."'>".$odkaz->dajNazov()."</a></li>\n";
      }
    }
    echo "</ul>\n";
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
      $link = $this->__zoznamOdkazov[0];
      include $this->__priecinokStranok.$link->dajLink().".php";
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
  $Render->nastavCSSAktivne("aktivne");
  
  //vygenerujem linky stranky
  $Render->vytvorLink("O jídelně");
  $Render->vytvorLink("Provozní řád");
  $Render->vytvorLink("Ceník stravování");
  $Render->vytvorLink("Jídelníček", "co-papame");
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