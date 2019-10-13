<?php

namespace App\Entity;

class Search 
{
    private $search;

    private $categories;

    public function getSearch() : ?string
    {
        return $this->search;
    }

    public function getCategories()
    {
        return $this->categories;
    }
    
    public function setSearch($search) : void
    {
        $this->search = $search;
    }
    
    public function setCategories($categories) : void
    {
        $this->categories = $categories;
    }
}
