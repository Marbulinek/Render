<?php
include_once "Render/Link.php";

/**
 * TRIEDA: Render.php
 * AUTOR: Lukas Caniga
 * KONTAKT: lukas.caniga(at)gmail.com
 *          http://marbulinek.cekuj.net
 * 
 * VERSION: 1.5
 * MODIFICATE DATE: 20.11.2016     
 */ 
Class Render
{
  private $_base;
  private $_dirPages;
  private $_pageNotFound;
  private $_cssActiveClass;
  
  private $_linkList;
  
  function __construct()
  {
    //$__link = new Link();
    
    /**
     *  default base for pages
	 *  example in url: ...?page=home
     */     
    $this->__base = "page";
    
    /**
     *  setting folder used for subsites    
     */    
    $this->_dirPages = "subSiteFolder";
    
    /**
     *  name of 404 subsite
     */    
    $this->_pageNotFound = "error";
    
    /**
     *  css selector for active link in the menu
     */         
    $this->__cssActive = "activeLink";
    
    
    $this->_linkList = array();
  }
  
  /**
   * Return link in SEO format
   * without diacritics and - instead of "space"
   */     
  private function CreateSEO($link)
  {
     $link = stripslashes($link);
     $link = str_replace(
       explode(',','á,ä,č,ď,é,ě,ë,í,ĺ,ľ,ň,ó,ö,ô,ř,š,ť,ú,ů,ü,ý,ž,Á,Ä,Č,Ď,É,Ě,Ë,Í,Ĺ,Ľ,Ň,Ó,Ö,Ô,Ř,Š,Ť,Ú,Ů,Ü,Ý,Ž, '),
       explode(',','a,a,c,d,e,e,e,i,l,l,n,o,o,o,r,s,t,u,u,u,y,z,a,a,c,d,e,e,e,i,l,l,n,o,o,o,r,s,t,u,u,u,y,z,-'),
     $link);
     $link = strtolower($link);
     $link = preg_replace('/[^-a-z0-9]/','-',$link);
     $link = preg_replace('/-+/','-',$link);
     $link = trim($link,'-');
     
     return $link;
  }
  
  /**
   * Set active link by inserting css selector (e.g. active)
   */     
  public function SetCSSActive($selector)
  {
    $this->_cssActiveClass = $selector;
  }
  
  /**
   * Set base alias in the url
   */     
  public function SetBase($base)
  {
    $this->_base = $base;
  }

  /**
   * Folder where are subpages located
   */     
  public function SetPagesDir($folder)
  {
    $lastChar = substr($folder, -1);
    $this->_dirPages = ($lastChar != "/")?$folder."/":$folder; 
  }
  
  /**
   * Set 404 own default - page not found
   */  
  public function Set404Page($page)
  {
    $this->_pageNotFound = $page; 
  }
  
  /**
   * Uses for creating list of links which should be rendered
   */ 
  public function CreateLink($name, $link = "")
  {
       if($link != "")
       {
         $tempLink = new Link($name, $link);
         $this->_linkList[] = $tempLink;
       }else{
         $link = $this->CreateSEO($name);
         $tempLink = new Link($name, $link);
         $this->_linkList[] = $tempLink;
       }
  }
  

  /*
  * Creating navigation menu
  * param highlight - if true then selector for active link will be used
  */
  public function RenderNavigator($paHighlight = true, $SEO = false)
  {
    foreach($this->_linkList as $link)
    {
      if(isSet($_GET[$this->_base]))
      {
        if($_GET[$this->_base] == $link->GetLink())
        {
          $activeCSSLink = ($paHighlight==true)?"class='".$this->_cssActiveClass."'":'';
		  $seoLink = $SEO==false ? $this->_base."=".$link->GetLink() : "/".$link->GetLink();
          echo "<li><a href='?".$seoLink."' $activeCSSLink>".$link->GetName()."</a></li>\n";
        }else{
          echo "<li><a href='?".$seoLink."'>".$link->GetName()."</a></li>\n";
        }
      }else{
         echo "<li><a href='?".$seoLink."'>".$link->GetName()."</a></li>\n"; 
      }
    }
  }
  
  /**
   * Rendering menu in the selected section
   */  
  public function RenderMenu()
  {
    if(isSet($_GET[$this->_base]))
    {
      $address = trim($_GET[$this->_base]);
      if(file_exists($this->_dirPages.$address.".php"))
      {
        include $this->_dirPages.$address.".php";
      }else{
        include $this->_dirPages.$this->_pageNotFound.".php";
      }                       
    }else{
      $link = $this->_linkList[0];
      include $this->_dirPages.$link->GetLink().".php";
    } 
  }

}
?>