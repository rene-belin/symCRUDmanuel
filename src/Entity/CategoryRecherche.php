<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

class CategoryRecherche
{
    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category = null;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
