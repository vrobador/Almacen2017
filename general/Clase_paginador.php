
<?php
class Clase_Paginador{
	public $pagina_activa;
	public $items_por_pagina;
	public $limite_final;
	public $limite_inicial;
	public $num_paginas;
	public $total_items;
	protected $ipp_array;
	protected $limit;
	protected $mid_range;
	protected $querystring=NULL;
	protected $return;
	protected $get_ipp;
	protected $concache;

public function __construct($concache=true,$total=0,$mid_range=7,$ipp_array=array(10,25,50,100,"Todos")) {
		$this->total_items = (int) $total;
		if($this->total_items <= 0) exit("Debe ser un entero > 0");
		$this->mid_range = (int) $mid_range; 
		if($this->mid_range < 1) exit("Debe ser un numero >= 1)");
		if(!is_array($ipp_array)) exit("Tiene que ser un array");
		$this->ipp_array = $ipp_array;
		$this->items_por_pagina = (isset($_GET["ipp"])) ? $_GET["ipp"] : $this->ipp_array[0];
		$this->concache=$concache;
		
if ($this->concache){	
		if($_GET) {
			$args = explode("&",$_SERVER["QUERY_STRING"]);
			foreach($args as $arg) {
				$keyval = explode("=",$arg);
				if($keyval[0] != "page" && $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}
		if($_POST) {
			foreach($_POST as $key=>$val) {
				if($key != "page" && $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}
}
if($this->items_por_pagina == "Todos") {
		$this->num_paginas = 1;
		$this->pagina_activa= 1;
		$this->return ="<a class='current' href='#'>1</a>";
		
 
}else {
		
	    if(!is_numeric($this->items_por_pagina) || $this->items_por_pagina <= 0) $this->items_por_pagina = $this->ipp_array[0];
		$this->num_paginas = ceil($this->total_items/$this->items_por_pagina);
		
		$this->pagina_activa = (isset($_GET["page"])) ? (int) $_GET["page"] : 1 ; 

		
		if($this->num_paginas > $this->mid_range+1) {
		    $this->anterior();
			
			$this->start_range = $this->pagina_activa - floor($this->mid_range/2);
			$this->end_range = $this->start_range+$this->mid_range-1;
			

			if($this->start_range <= 0) {
				$this->start_range = 1;
				$this->end_range =$this->start_range+$this->mid_range-1;
			}
			if($this->end_range > $this->num_paginas) {
				$this->end_range = $this->num_paginas;
				$this->start_range=$this->end_range-$this->mid_range+1;
			}
			$this->range = range($this->start_range,$this->end_range);

			if($this->range[0]>2)
				$this->return .="<a class=paginate title='Ir a la página 1 de $this->num_paginas' href='$_SERVER[PHP_SELF]?page=1&ipp=$this->items_por_pagina$this->querystring'>1</a>"." ... "; 
			
			foreach($this->range as $i=>$va){
				if ($va==$this->pagina_activa ){
					$this->return .="<a title='Ir a la página $va de $this->num_paginas' class=current href='#'>$va</a>"; 
				}else{
		            $this->return .="<a class='paginate' title='Ir a la página $va de $this->num_paginas' href='$_SERVER[PHP_SELF]?page=$va&ipp=$this->items_por_pagina$this->querystring  '>$va</a>";
				}
			}
			if($this->range[$this->mid_range-1] < $this->num_paginas-1)
			$this->return .=" ... "."<a class=paginate title='Ir a la página $this->num_paginas' href='$_SERVER[PHP_SELF]?page=$this->num_paginas&ipp=$this->items_por_pagina$this->querystring'>$this->num_paginas</a>"; 
			
			$this->siguiente();
			
			$this->todos();
			 
			
		} else	{
			$this->anterior();
			 
			for($i=1;$i<=$this->num_paginas;$i++) {
				 
				if ($i == $this->pagina_activa){
				   $this->return .= "<a class='current' href='#'>$i</a> ";
			    }else{
			    	$this->return .="<a class='paginate' href='$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_por_pagina$this->querystring'>$i</a> ";
				}
			}
			$this->siguiente();
			$this->todos();
		 }
}
		$this->return = str_replace("&","&amp;",$this->return);
		$this->limite_inicial = ($this->pagina_activa <= 0) ? 0:($this->pagina_activa-1) * $this->items_por_pagina;
		if($this->pagina_activa <= 0) $this->items_por_pagina = 0;
		$this->limite_final = ($this->items_por_pagina == "Todos") ? (int) $this->total_items: (int) $this->items_por_pagina;
	}
	public function display_items_por_pagina() {
		$items = NULL;
		natsort($this->ipp_array);  
		foreach($this->ipp_array as $ipp_opt) 
		$items .= ($ipp_opt == $this->items_por_pagina) ? "<option selected value='$ipp_opt'>$ipp_opt</option>":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		return "<span class='paginate'>Items por pagina:</span><select class='paginate' onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&amp;ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}
	public function display_jump_menu() {
		$option=NULL;
		for($i=1;$i<=$this->num_paginas;$i++) {
			$option .= ($i==$this->pagina_activa) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"paginate\">Pagina:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&amp;ipp=$this->items_por_pagina$this->querystring';return false\">$option</select>\n";
	}
	public function display_pages() {
		return $this->return;
	}
	private function anterior(){
	if ($this->pagina_activa > 1){
					$this->return .=  "<a class='paginate' href='$_SERVER[PHP_SELF]?page=".($this->pagina_activa-1)."&ipp=$this->items_por_pagina$this->querystring'><</a>";
			}else{
				    $this->return ="<span class='inactive' href='#'><</span> ";
			}
	}
	private function siguiente(){
	if ($this->pagina_activa < $this->num_paginas  ){
			    $this->return .=  "<a class=\"paginate\" style=\"margin-left:5px\" href=\"$_SERVER[PHP_SELF]?page=".($this->pagina_activa+1)."&ipp=$this->items_por_pagina$this->querystring\">></a>\n";
			}else{
				$this->return .=  "<span class=\"inactive\" style=\"margin-left:5px\" href=\"#\">></span>\n";
			}
	}
	private function todos(){
		$this->return .= "<a class='paginate' style='margin-left:10px' href='$_SERVER[PHP_SELF]?page=1&ipp=Todos$this->querystring'>Todos</a>";

	}
}