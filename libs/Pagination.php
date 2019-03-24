<?php
class Pagination{
	
	private $totalItems;					// Tổng số phần tử
	private $totalItemsPerPage		= 1;	// Tổng số phần tử xuất hiện trên một trang
	private $pageRange				= 5;	// Số trang xuất hiện
	private $totalPage;						// Tổng số trang
	private $currentPage			= 1;	// Trang hiện tại
	
	public function __construct($totalItems, $pagination){
		$this->totalItems			= $totalItems;
		$this->totalItemsPerPage	= $pagination["totalItemPerPage"];
		
		if($pagination["pageRange"] %2 == 0) $pagination["pageRange"] = $pagination["pageRange"] + 1;
		
		$this->pageRange			= $pagination["pageRange"];
		$this->currentPage			= $pagination["currentPage"];
		$this->totalPage			= ceil($totalItems/$this->totalItemsPerPage);
	}
	
	public function showPagination($link){
		// Pagination
		$paginationHTML = '';
		if($this->totalPage > 1){
			$start 	= '<div class="button2-right off"><div class="start"><span>Start</span></div></div>';
			$prev 	= '<div class="button2-right off"><div class="prev"><span>Prev</span></div></div>';
			if($this->currentPage > 1){
				$start 	= '<div class="button2-right"><div class="start"><a href="javascript:changePage(1)">Start</a></div></div>';
				$prev 	= '<div class="button2-right"><div class="prev"><a href="javascript:changePage('."$this->currentPage-1".')">Previous</a></div></div>';
			}
		
			$next 	= '<div class="button2-left off"><div class="next"><span>Next</span></div></div>';
			$end 	= '<div class="button2-left off"><div class="end"><span>End</span></div></div>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<div class="button2-left"><div class="next"><a href="javascript:changePage('."$this->currentPage+1".')">Next</a></div></div>';
				$end 	= '<div class="button2-left"><div class="end"><a href="javascript:changePage('."$this->totalPage".')">End</a></div></div>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}
			$listPages = '<div class="button2-left"><div class="page">';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {	
					$listPages .= '<span>'.$i.'</span>';
				}else{
					$listPages .= '<a href="javascript:changePage('."$i".')">'.$i.'</a>';
				}
			}
			$listPages .= '</div></div>';
			$endPagination = '<div class="limit">Page ' . $this->currentPage . "of " . $this->totalPage . "</div>";
		
			$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end . $endPagination . '</ul>';
		}
		return $paginationHTML;
	}

	public function showPaginationDF($link){
		// Pagination
		$paginationHTML = '';
		if($this->totalPage > 1){
			$start 	= '<div class="button2-right off"><div class="start"><span>Start</span></div></div>';
			$prev 	= '<div class="button2-right off"><div class="prev"><span>Prev</span></div></div>';
			if($this->currentPage > 1){
				$start 	= '<div class="button2-right"><div class="start"><a href="javascript:changePage(1)">Start</a></div></div>';
				$prev 	= '<div class="button2-right"><div class="prev"><a href="javascript:changePage('."$this->currentPage-1".')">Previous</a></div></div>';
			}
		
			$next 	= '<div class="button2-left off"><div class="next"><span>Next</span></div></div>';
			$end 	= '<div class="button2-left off"><div class="end"><span>End</span></div></div>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<div class="button2-left"><div class="next"><a href="javascript:changePage('."$this->currentPage+1".')">Next</a></div></div>';
				$end 	= '<div class="button2-left"><div class="end"><a href="javascript:changePage('."$this->totalPage".')">End</a></div></div>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}
			$listPages = '<div class="button2-left"><div class="page">';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {	
					$listPages .= '<span>'.$i.'</span>';
				}else{
					$listPages .= '<a href="javascript:changePage('."$i".')">'.$i.'</a>';
				}
			}
			$listPages .= '</div></div>';
			$endPagination = '<div class="limit">Page ' . $this->currentPage . "of " . $this->totalPage . "</div>";
		
			$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end . $endPagination . '</ul>';
		}
		return $paginationHTML;
	}
}