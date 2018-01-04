<?php

namespace GSB\mainBundle\Entity;

/**
 * praticien
 */
class praticien
{
    /**
     * @var int
     */
    private $idPraticien;

    /**
     * @var int
     */
    private $idTypePraticien;

    /**
     * @var string
     */
    private $nomPraticien;

    /**
     * @var string
     */
    private $prenomPraticien;

    /**
     * @var string
     */
    private $adressePraticien;

    /**
     * @var string
     */
    private $cpPraticien;

    /**
     * @var string
     */
    private $villePraticien;

    /**
     * @var string
     */
    private $coefNotoriete;


    /**
     * Set idPraticien
     *
     * @param integer $idPraticien
     *
     * @return praticien
     */
    public function setIdPraticien($idPraticien)
    {
        $this->idPraticien = $idPraticien;

        return $this;
    }

    /**
     * Get idPraticien
     *
     * @return int
     */
    public function getIdPraticien()
    {
        return $this->idPraticien;
    }

    /**
     * Set idTypePraticien
     *
     * @param integer $idTypePraticien
     *
     * @return praticien
     */
    public function setIdTypePraticien($idTypePraticien)
    {
        $this->idTypePraticien = $idTypePraticien;

        return $this;
    }

    /**
     * Get idTypePraticien
     *
     * @return int
     */
    public function getIdTypePraticien()
    {
        return $this->idTypePraticien;
    }

    /**
     * Set nomPraticien
     *
     * @param string $nomPraticien
     *
     * @return praticien
     */
    public function setNomPraticien($nomPraticien)
    {
        $this->nomPraticien = $nomPraticien;

        return $this;
    }

    /**
     * Get nomPraticien
     *
     * @return string
     */
    public function getNomPraticien()
    {
        return $this->nomPraticien;
    }

    /**
     * Set prenomPraticien
     *
     * @param string $prenomPraticien
     *
     * @return praticien
     */
    public function setPrenomPraticien($prenomPraticien)
    {
        $this->prenomPraticien = $prenomPraticien;

        return $this;
    }

    /**
     * Get prenomPraticien
     *
     * @return string
     */
    public function getPrenomPraticien()
    {
        return $this->prenomPraticien;
    }

    /**
     * Set adressePraticien
     *
     * @param string $adressePraticien
     *
     * @return praticien
     */
    public function setAdressePraticien($adressePraticien)
    {
        $this->adressePraticien = $adressePraticien;

        return $this;
    }

    /**
     * Get adressePraticien
     *
     * @return string
     */
    public function getAdressePraticien()
    {
        return $this->adressePraticien;
    }

    /**
     * Set cpPraticien
     *
     * @param string $cpPraticien
     *
     * @return praticien
     */
    public function setCpPraticien($cpPraticien)
    {
        $this->cpPraticien = $cpPraticien;

        return $this;
    }

    /**
     * Get cpPraticien
     *
     * @return string
     */
    public function getCpPraticien()
    {
        return $this->cpPraticien;
    }

    /**
     * Set villePraticien
     *
     * @param string $villePraticien
     *
     * @return praticien
     */
    public function setVillePraticien($villePraticien)
    {
        $this->villePraticien = $villePraticien;

        return $this;
    }

    /**
     * Get villePraticien
     *
     * @return string
     */
    public function getVillePraticien()
    {
        return $this->villePraticien;
    }

    /**
     * Set coefNotoriete
     *
     * @param string $coefNotoriete
     *
     * @return praticien
     */
    public function setCoefNotoriete($coefNotoriete)
    {
        $this->coefNotoriete = $coefNotoriete;

        return $this;
    }

    /**
     * Get coefNotoriete
     *
     * @return string
     */
    public function getCoefNotoriete()
    {
        return $this->coefNotoriete;
    }
}

