<?php

namespace GSB\mainBundle\Entity;

/**
 * famille
 */
class famille
{
    /**
     * @var int
     */
    private $idFamille;

    /**
     * @var string
     */
    private $libFamille;


    /**
     * Set idFamille
     *
     * @param integer $idFamille
     *
     * @return famille
     */
    public function setIdFamille($idFamille)
    {
        $this->idFamille = $idFamille;

        return $this;
    }

    /**
     * Get idFamille
     *
     * @return int
     */
    public function getIdFamille()
    {
        return $this->idFamille;
    }

    /**
     * Set libFamille
     *
     * @param string $libFamille
     *
     * @return famille
     */
    public function setLibFamille($libFamille)
    {
        $this->libFamille = $libFamille;

        return $this;
    }

    /**
     * Get libFamille
     *
     * @return string
     */
    public function getLibFamille()
    {
        return $this->libFamille;
    }
}

