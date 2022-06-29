<?php
class Paginator 
{       
    public $itemsPerPage;
    public $range;
    public $currentPage;
    public $total;
    public $textNav;
    private $_navigation;       
    private $_link;
    private $_pageNumHtml;
    private $_itemHtml;

    public $is_ajax = false;

    public function __construct($page = 1)
    {
        $this->itemsPerPage = 30;
        $this->range        = 3;
        $this->currentPage  = $page;
        $this->total        = 0;
        $this->textNav      = true;     


        $this->_navigation  = array(
         'next'=>"<img src='".base_url('assets/front/images/right-arrow.png')."' width='30px'/>",
         'prev' =>"<img src='".base_url('assets/front/images/left.png')."' width='48px' style ='margin-right:-20px;' />",
         'first' =>"<img src='".base_url('assets/front/images/category-next-arrow.png')."' width='17px' style ='transform: rotate(180deg); position:relative; left:16px;' />",
         'last' =>"<img src='".base_url('assets/front/images/category-next-arrow.png')."' width='33px' style ='margin-left:-17px; ' />",
         'ipp' =>'Item per page'
        );

        $this->_link         = filter_var($_SERVER['REDIRECT_URL'], FILTER_SANITIZE_STRING);
        $this->_pageNumHtml  = '';
        $this->_itemHtml     = '';
    }

    public function paginate()
    {
        if(isset($_POST['current'])){
            $this->currentPage  = $_POST['current'];        
        }

        if(isset($_GET['item'])){
            $this->itemsPerPage = $_GET['item'];
        }           

        $this->_pageNumHtml = $this->_getPageNumbers();         
        return $this->_pageNumHtml;
    }


    public function pageNumbers()
    {
        if(empty($this->_pageNumHtml))
        {
            exit('Please call function paginate() first.');
        }
        return $this->_pageNumHtml;
    }


    public function itemsPerPage()
    {          
        if(empty($this->_itemHtml))
        {
            exit('Please call function paginate() first.');
        }
        return $this->_itemHtml;    
    } 


    private function  _getPageNumbers()
    {
        $html  = '<div class="paginations">';
        $html .= '<div class="">';
        $html .= '<div class="row mx-2">';
        $html .= '<div class="col-md-12">';
        $html .= '<ul class="list-unstyled">';

        $query_string = $_GET;
        $str = array();

        if(count($query_string) > 0)
        {
            foreach ($query_string as $key => $value) 
            {
                if($key != 'pages'){
                    $str[] = "$key=$value";
                }
            }
        }

        if($this->currentPage > 1)
        {
            $first = $str;
            $first[] = "pages=1";

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $first);
            } else {
                $string = 'javascript:void(0)';
            }
            $page_prev = $this->currentPage - 1;

            $html .= '<li class="page-item asd">';
            $html .= '<a class="page-link ajax_page" href="'.$string.'" data-pages="1">'.$this->_navigation['first'].'</a></li>';

            $html .= '<li class="page-item asd">';
            $html .= '<a class="page-link ajax_page" href="'.$string.'" data-pages="'.$page_prev.'">'.$this->_navigation['prev'].'</a></li>';
        }

        if(($this->currentPage>1))
        {
            $prev = $str;
            $prev[] = "pages=".($this->currentPage-1);

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $prev);
            } else {
                $string = 'javascript:void(0)';
            }
        }

        $last = ceil($this->total/$this->itemsPerPage);

        if($this->total > $this->range)
        {
            if($this->currentPage <= $this->range)
            {
                $start = 1;
            } else {
                $start = $this->currentPage - $this->range;
            }
        
            if($this->currentPage+$this->range > $last)
            {
                $end = $last;
            } else if ($this->currentPage+$this->range <= $last) {
                $end = $this->currentPage+$this->range;
            }
        } else {
            if($total > $this->itemsPerPage)
            {
                $start = 1;
                $end   = $this->total;
            } else {
                $start = 1;
                $end   = 1;
            }
        }    


        for($i = $start; $i <= $end; $i++)
        {
            $p = $str;
            $p[] = "pages=".$i;

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $p);
            } else {
                $string = 'javascript:void(0)';
            }
            

            if($i==$this->currentPage) {
                $html .= '<li class="page-item active">';
                $html .= '<a href="'.$string.'" data-pages="'.$i.'"';
                $html .= ' class="page-link active"';
            }else{
                $html .= '<li class="page-item">';
                $html .= '<a href="'.$string.'" data-pages="'.$i.'"';
                $html .= ' class="ajax_page page-link"';
            }
            $html .= '>'.$i.'</a>';
            $html .= '</li>';
        }           

        if(($this->currentPage < ($this->total/$this->itemsPerPage)))
        {
            $next = $str;
            $next[] = "pages=".($this->currentPage+1);

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $next);
            } else {
                $string = 'javascript:void(0)';
            }
        }

        if($this->currentPage < $last)
        {
            $end = $str;
            $end[] = "pages=".$last;

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $end);
            } else {
                $string = 'javascript:void(0)';
            }

            $page_next = $this->currentPage + 1;

            $html .= '<li class="page-item asd">';
            $html .= '<a class="page-link ajax_page" href="'.$string.'" data-pages="'.$page_next.'">'.$this->_navigation['next'].'</a></li>';

            $html .= '<li class="page-item asd">';
            $html .= '<a class="page-link ajax_page" href="'.$string.'" data-pages="'.$last.'">'.$this->_navigation['last'].'</a></li>';
            
        }

        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}