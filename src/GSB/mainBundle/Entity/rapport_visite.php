<?php

namespace GSB\mainBundle\Entity;

/**
 * rapport_visite
 */
class rapport_visite
{
    /**
     * @var int
     */
    private $idRapport;

    /**
     * @var array
     */
    private $praticien;

    /**
     * @var array
     */
    private $visiteur;

    /**
     * @var \DateTime
     */
    private $dateRapport;

    /**
     * @var string
     */
    private $bilan;

    /**
     * @var string
     */
    private $motif;


    /**
     * Set rapport
     *
     * @param int $rapport
     *
     * @return rapport_visite
     */
    public function setIdRapport($idRapport)
    {
        $this->idRapport = $idRapport;

        return $this;
    }

    /**
     * Get rapport
     *
     * @return int
     */
    public function getIdRapport()
    {
        return $this->idRapport;
    }

    /**
     * Set praticien
     *
     * @param array $praticien
     *
     * @return rapport_visite
     */
    public function setPraticien($praticien)
    {
        $this->praticien = $praticien;

        return $this;
    }

    /**
     * Get praticien
     *
     * @return array
     */
    public function getPraticien()
    {
        return $this->praticien;
    }

    /**
     * Set visiteur
     *
     * @param array $visiteur
     *
     * @return rapport_visite
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
     * Set dateRapport
     *
     * @param \DateTime $dateRapport
     *
     * @return rapport_visite
     */
    public function setDateRapport($dateRapport)
    {
        $this->dateRapport = $dateRapport;

        return $this;
    }

    /**
     * Get dateRapport
     *
     * @return \DateTime
     */
    public function getDateRapport()
    {
        return $this->dateRapport;
    }

    /**
     * Set bilan
     *
     * @param string $bilan
     *
     * @return rapport_visite
     */
    public function setBilan($bilan)
    {
        $this->bilan = $bilan;

        return $this;
    }

    /**
     * Get bilan
     *
     * @return string
     */
    public function getBilan()
    {
        return $this->bilan;
    }

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return rapport_visite
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }
}

