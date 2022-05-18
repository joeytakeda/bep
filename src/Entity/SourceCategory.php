<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\SourceCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=SourceCategoryRepository::class)
 */
class SourceCategory extends AbstractTerm {
    /**
     * @var Collection|ManuscriptSource[]
     * @ORM\OneToMany(targetEntity="ManuscriptSource", mappedBy="sourceCategory")
     */
    private $manuscriptSources;

    public function __construct() {
        parent::__construct();
        $this->manuscriptSources = new ArrayCollection();
    }

    /**
     * @return Collection|ManuscriptSource[]
     */
    public function getManuscriptSources() : Collection {
        return $this->manuscriptSources;
    }

    public function addManuscriptSource(ManuscriptSource $manuscriptSource) : self {
        if ( ! $this->manuscriptSources->contains($manuscriptSource)) {
            $this->manuscriptSources[] = $manuscriptSource;
            $manuscriptSource->setSourceCategory($this);
        }

        return $this;
    }

    public function removeSource(ManuscriptSource $manuscriptSource) : self {
        if ($this->manuscriptSources->removeElement($manuscriptSource)) {
            // set the owning side to null (unless already changed)
            if ($manuscriptSource->getSourceCategory() === $this) {
                $manuscriptSource->setSourceCategory(null);
            }
        }

        return $this;
    }
}
