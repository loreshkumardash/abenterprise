<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paginator{

	var $previous;
    var $current;
    var $next;
    var $page;
    var $total_pages;
    var $range1;
    var $range2;
    var $num_rows;
    var $first;
    var $last;
    var $first_of;
    var $second_of;
    var $limit;
    var $prev_next;
    var $base_page_num;
    var $extra_page_num;
    var $total_items;
    var $pagename;

    /* Constructor for Paginator 
	function __construct($params){
		if(!$params['page_num']) $this->page = 1;
		else $this->page = $params['page_num'];
		$this->num_rows = $params['num_rows'];
		$this->total_items = $this->num_rows;
	}*/
	
	function setparam($params){
		if(!$params['page_num']) $this->page = 1;
		else $this->page = $params['page_num'];
		$this->num_rows = $params['num_rows'];
		$this->total_items = $this->num_rows;
	}

	function set_Limit($limit=5){
		$this->limit = $limit;
		$this->setBasePage();
		$this->setExtraPage();
	}

	/* Creates a number that setExtraPage() uses to if there are
	and extra pages after limit has divided the total number of pages.*/
	function setBasePage(){
		$div=$this->num_rows/$this->limit;
		$this->base_page_num=floor($div);
	}
	
	function setExtraPage(){
		$this->extra_page_num=$this->num_rows - ($this->base_page_num*$this->limit);
	}

	/* method to get the total items.*/
	function getTotalItems(){
		$this->total_items = $this->num_rows;
		return $this->total_items;
	}

	/*method to get the base number to use in queries and such*/
	function getRange1(){
		$this->range1=($this->limit*$this->page)-$this->limit;
		return $this->range1;
	}

	/*method to get the offset.*/
	function getRange2(){
		if($this->page == $this->base_page_num + 1){
			$this->range2 = $this->extra_page_num;
		}else{
			$this->range2=$this->limit;
		}
		return $this->range2;
	}

	/*method to get the total number of pages. */
	function getTotalPages(){
		if($this->extra_page_num){
		$this->total_pages = $this->base_page_num + 1;
		} else {
		$this->total_pages = $this->base_page_num;
		}
		return $this->total_pages;
	}

	/* method to get the first link number.*/
	function getFirst(){
		$this->first=1;
		return $this->first;
	}

	/* method to get the last link number.*/
	function getLast(){
		if($this->page == $this->total_pages){
			$this->last=0;
		}else{
			$this->last = $this->total_pages;
		}
		return $this->last;
	}

	function getPrevious(){
		if($this->page > 1){
			$this->previous = $this->page - 1;
		}
		return $this->previous;
	}

	/* method to get the number of the link previous to the current link.*/
	function getCurrent(){
		$this->current = $this->page;
		return $this->current;
	}

	/*method to get the current page name. Is mostly used in links to the next page */
	function getPageName(){
		$this->pagename = $_SERVER['PHP_SELF'];
		return $this->pagename;
	}

	/*method to get the number of the link after the current link */
	function getNext(){
		$this->getTotalPages();
		if($this->total_pages != $this->page){
		$this->next = $this->page + 1;
		}
		return $this->next;
	}
	
	function DBPagingNav_back($queryvars='')
	{
	    if($this->getCurrent()==1) $first = "First | ";
            else {
                $first="<a href=\"" .  $this->getPageName() . "?page=" . $this->getFirst() . '&'.$queryvars."\">First</a> |"; }
		if($this->getPrevious()){
		    $prev = "<a href=\"" .  $this->getPageName() . "?page=" . $this->getPrevious() .'&'.$queryvars. "\">Prev</a> | ";
		}
		else $prev="Prev | ";
		if($this->getNext()){
		    $next = "<a href=\"" . $this->getPageName() . "?page=" . $this->getNext() .'&'.$queryvars. "\">Next</a> | ";
		}
		else $next="Next | ";
		if($this->getLast()){
		    $last = "<a href=\"" . $this->getPageName() . "?page=" . $this->getLast() .'&'.$queryvars. "\">Last</a>  ";
		}
		else $last="Last  ";
	        echo($first . " " . $prev." Page <font class='headertextbold'>".$this->getCurrent() . "</font> of " . $this->getTotalPages() . " | ". $next . " " . $last);
	}

	function DBPagingNav($queryvars='', $urls = 'index.php')
	{

		$max_disp = 5;
	    $tot = $this->getTotalPages();
	    $curr = $this->getCurrent();

	    $start = (($curr - 4) > 0) ? $curr - 4 : 1;

	    if(($curr + 4) > $tot)
	    {
	    	$start = $tot - 8;

	    	if($start < 1) $start = 1;
	    }

	    $str = '<div class="pull-right" id="">';

	    $str .= "\n".'<ul class="pagination">';

	    if($prev = $curr - 1)
	    {
	    	$str .= "\n".'<li class="prevPage"><a href="'.$urls . "?page=1" .'&'. $queryvars.'" title="First"><i class="ace-icon fa fa-angle-double-left"></i></a></li>';
	    	$str .= "\n".'<li class="prevPage"><a href="'.$urls . "?page=" . $prev .'&'. $queryvars.'" title="Previous"><i class="ace-icon fa fa-angle-left"></i></a></li>';
	    }

	    if($start != $tot)
	    {
			for($i=$start,$j=1;$j<=$max_disp && $i <= $tot;$i++,$j++)
			{
				$cls_name = ($i == $curr) ? ' class="active"' : '';
				$url = $urls . "?page=" . $i .'&'. $queryvars;
				$str .= "\n".'<li '.$cls_name.'><a href="'.$url.'">'.$i.'</a></li>';
			}
	    }

	    $next = $curr + 1;

	    if($next <= $tot)
	    {
	    	$str .= "\n".'<li class=""><a href="'.$urls . "?page=" . $next .'&'. $queryvars.'" title="Next"><i class="ace-icon fa fa-angle-right"></i></a></li>';
	    	$str .= "\n".'<li class="nextPage"><a href="'.$urls . "?page=" . $tot .'&'. $queryvars.'" title="Last"><i class="ace-icon fa fa-angle-double-right"></i></a></li>';
	    }

	    $str .= "\n".'</ul>';
	    $str .= "\n".'</div>';

	    $str1 = "Page <b>".$curr . "</b> of " . $tot;

	    return array($str1,$str);
	}
}
// END Paginator Class