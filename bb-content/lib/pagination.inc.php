<?php
/**
 * Pagination generator
 */
class Pagination 
{
    private $items_per_page = 0;
    private $items_total = 0;
    private $mid_range = 7;
    private $page_name = 'page';
    private $base_uri = null;

    // styling
    private $div_class = 'pagination';
    private $ul_class = '';
    private $link_class = 'paginate';
    private $link_active_class = '';

    public function __construct() {
        // nothing
    }

    public function base_uri($uri) {
        $this->base_uri = $uri;

        // chainability
        return $this;
    }

    public function total($total) {
        $this->items_total = $total;

        // chainability
        return $this;
    }

    public function mid_range($range) {
        $this->mid_range = $range;

        // chainability
        return $this;
    }

    public function per_page($n) {
        $this->items_per_page = $n;

        // chainability
        return $this;
    }

    public function page_name($name) {
        $this->page_name = $name;

        // chainability
        return $this;
    }

    public function div_class($class) {
        $this->div_class = $class;

        // chainability
        return $this;
    }

    public function ul_class($class) {
        $this->ul_class = $class;

        // chainability
        return $this;
    }

    public function link_class($class) {
        $this->link_class = $class;

        // chainability
        return $this;
    }

    public function link_active_class($class) {
        $this->link_active_class = $class;

        // chainability
        return $this;
    }

    public function paginate() {
        if($this->items_total == 0 || $this->items_per_page == 0) {
            throw new Exception('total and per_page must be set');
        }

        $base_uri = $this->base_uri;
        // If the base_uri is not set, find it out!
        if(is_null($base_uri)) {
            $base_uri = explode('?', $_SERVER['REQUEST_URI']);
            $base_uri = $base_uri[0] . '?';

            $args = array();
            foreach($_GET as $key => $value) {
                if($key != $this->page_name) {
                    $args[$key] = $value;
                }
            }

            if(count($args) > 0) {
                $base_uri .= http_build_query($args, '', '&amp;') . '&amp;';
            }
        }

        $total_pages = ceil($this->items_total / $this->items_per_page);
        $current_page = (int)@$_GET[$this->page_name]; // must be numeric > 0
        $output = '<div class="' . $this->div_class . '"><ul class="' . $this->ul_class . '">';

        if($current_page < 1) {
            $current_page = 1;
        } else if($current_page > $total_pages) {
            $current_page = $total_pages;
        }

        $prev_page = $current_page - 1;
        $next_page = $current_page + 1;

        if($total_pages > $this->items_per_page) {
            $output .= ($current_page != 1 && $this->items_total >= $this->items_per_page) 
                ? '<li><a class="paginate '.$this->link_class.' prev" href="' . $base_uri . $this->page_name . '=' . $prev_page . '">«</a></li>'
                : '<li class="disabled"><a class="'.$this->link_class.' prev">«</a></li>'; 

            $this->start_range = $current_page - floor($this->mid_range / 2);
            $this->end_range = $current_page + floor($this->mid_range / 2);

            if($this->start_range <= 0) {
                $this->end_range += abs($this->start_range) + 1;
                $this->start_range = 1;
            }

            if($this->end_range > $total_pages) {
                $this->start_range -= $this->end_range - $total_pages;
                $this->end_range = $total_pages;
            }

            $this->range = range($this->start_range, $this->end_range);
            for($i = 1; $i <= $total_pages; $i++) {
                if($this->range[0] > 2 && $i == $this->range[0]) 
                    $output .= '<li class="disabled"><a class="'.$this->link_class.'"> ... </a></li>';

                if($i == 1 || $i == $total_pages || in_array($i, $this->range)) {
                    $output .= ($i == $current_page) 
                        ? '<li class="active"><a class="'.$this->link_class.' '.$this->link_active_class.'" title="Go to page '.$i.' of '.$total_pages.'">'.$i.'</a></li>'
                        : '<li><a class="'.$this->link_class.'" title="Go to page '.$i.' of '.$total_pages.'" href="'.$base_uri.$this->page_name.'='.$i.'">'.$i.'</a></li>';
                }

                if($this->range[$this->mid_range-1] < $total_pages-1 && $i == $this->range[$this->mid_range-1]) 
                    $output .= '<li class="disabled"><a class="'.$this->link_class.'"> ... </a></li>';
            }

            $output .= (($current_page != $total_pages && $this->items_total >= $this->items_per_page) && (@$_GET[$this->page_name] != 'All')) 
                ? '<li><a class="'.$this->link_class.' next" href="'.$base_uri.$this->page_name.'='.$next_page.'">»</a></li>'
                : '<li class="disabled"><a class="'.$this->link_class.' next">»</a></li>';
        }
        else
        {
            $output .= '<li class="disabled"><a class="'.$this->link_class.' prev">«</a></li>';
            for($i=1;$i<=$total_pages;$i++) {
                $output .= ($i == $current_page) 
                    ? '<li class="active"><a class="'.$this->link_class.' '.$this->link_active_class.'">'.$i.'</a></li>'
                    : '<li><a class="'.$this->link_class.'" href="'.$base_uri.$this->page_name.'='.$i.'">'.$i.'</a></li>';
            }
            $output .= '<li class="disabled"><a class="'.$this->link_class.' next">»</a></li>';
        }

        return $output . '</ul></div>';
    }
}

