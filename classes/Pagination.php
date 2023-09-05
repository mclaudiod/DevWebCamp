<?php

    namespace Classes;

    class Pagination {
        public $currentPage;
        public $registriesPerPage;
        public $totalRegistries;

        public function __construct($currentPage = 1, $registriesPerPage = 10, $totalRegistries = 0) {
            $this->currentPage = (int) $currentPage;
            $this->registriesPerPage = (int) $registriesPerPage;
            $this->totalRegistries = (int) $totalRegistries;
        }

        public function offset() {
            return $this->registriesPerPage * ($this->currentPage - 1);
        }

        public function totalPages() {
            return ceil($this->totalRegistries / $this->registriesPerPage);
        }

        public function previousPage() {
            $previous = $this->currentPage - 1;
            return ($previous > 0) ? $previous : false;
        }

        public function nextPage() {
            $next = $this->currentPage + 1;
            return ($next <= $this->totalPages()) ? $next : false;
        }

        public function previousLink() {
            $html = "";

            if($this->previousPage()) {
                $html .= "<a class=\"pagination__link pagination__link--text\" href=\"?page={$this->previousPage()}\">&laquo; Previous</a>";
            }

            return $html;
        }

        public function nextLink() {
            $html = "";

            if($this->nextPage()) {
                $html .= "<a class=\"pagination__link pagination__link--text\" href=\"?page={$this->nextPage()}\">Next &raquo;</a>";
            }

            return $html;
        }

        public function pagesNumbers() {
            $html = "";

            for($i = 1; $i<= $this->totalPages(); $i++) {
                if($i === $this->currentPage) {
                    $html .= "<span class=\"pagination__link pagination__link--current\">{$i}</span>";
                } else {
                    $html .= "<a class=\"pagination__link pagination__link--number\" href=\"?page={$i}\">{$i}</a>";
                }
            }

            return $html;
        }

        public function pagination() {
            $html = "";

            if($this->totalRegistries > 1) {
                $html .= '<div class="pagination">';
                $html .= $this->previousLink();
                $html .= $this->pagesNumbers();
                $html .= $this->nextLink();
                $html .= '</div>';
            }

            return $html;
        }
    }