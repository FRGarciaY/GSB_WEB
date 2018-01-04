<?php

namespace GSB\mainBundle\Entity;

/**
 * offrir
 */
class offrir
{
    /**
     * @var int
     */
    private $idOffrir;
    
    /**
     * @var array
     */
    private $medicament;
    
    /**
     * @var array
     */
    private $rapport;

    /**
     * @var array
     */
    private $visiteur;
    
    /**
     * @var int
     */
    private $qteOfferte;

    /**
     * Set medicament
     *
     * @param array $idOffrir
     *
     * @return offrir
     */
    public function setIdOffrir($idOffrir)
    {
        $this->idOffrir = $idOffrir;

        return $this;
    }

    /**
     * Get medicament
     *
     * @return array
     */
    public function getIdOffrir()
    {
        return $this->idOffrir;
    }
    
    /**
     * Set medicament
     *
     * @param array $medicament
     *
     * @return offrir
     */
    public function setMedicament($medicament)
    {
        $this->medicament = $medicament;

        return $this;
    }

    /**
     * Get medicament
     *
     * @return array
     */
    public function getMedicament()
    {
        return $this->medicament;
    }

    /**
     * Set rapport
     *
     * @param array $rapport
     *
     * @return offrir
     */
    public function setRapport($rapport)
    {
        $this->rapport = $rapport;

        return $this;
    }

    /**
     * Get rapport
     *
     * @return array
     */
    public function getRapport()
    {
        return $this->rapport;
    }

    /**
     * Set visiteur
     *
     * @param array $visiteur
     *
     * @return offrir
     */
    public function setVisiteur($visiteur)
    {
        $this->visiteur = $visiteur;

        return $this;
    }

    /**
     * Get visiteur
     *
     * @return array
     */
    public function getVisiteur()
    {
        return $this->visiteur;
    }

    /**
     * Set qteOfferte
     *
     * @param integer $qteOfferte
     *
     * @return offrir
     */
    public function setQteOfferte($qteOfferte)
    {
        $this->qteOfferte = $qteOfferte;

        return $this;
    }

    /**
     * Get qteOfferte
     *
     * @return int
     */
    public function getQteOfferte()
    {
        return $this->qteOfferte;
    }
}

