<?php

namespace GSB\mainBundle\Entity;

/**
 * medicament
 */
class medicament
{
    /**
     * @var int
     */
    private $idMedicament;

    /**
     * @var array
     */
    private $famille;

    /**
     * @var string
     */
    private $depotLegal;

    /**
     * @var string
     */
    private $nomCommercial;

    /**
     * @var string
     */
    private $effets;

    /**
     * @var string
     */
    private $contreIndication;

    /**
     * @var string
     */
    private $prixEchantillon;


    /**
     * Set idMedicament
     *
     * @param integer $idMedicament
     *
     * @return medicament
     */
    public function setIdMedicament($idMedicament)
    {
        $this->idMedicament = $idMedicament;

        return $this;
    }

    /**
     * Get idMedicament
     *
     * @return int
     */
    public function getIdMedicament()
    {
        return $this->idMedicament;
    }

    /**
     * Set famille
     *
     * @param array $famille
     *
     * @return medicament
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return array
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set depotLegal
     *
     * @param string $depotLegal
     *
     * @return medicament
     */
    public function setDepotLegal($depotLegal)
    {
        $this->depotLegal = $depotLegal;

        return $this;
    }

    /**
     * Get depotLegal
     *
     * @return string
     */
    public function getDepotLegal()
    {
        return $this->depotLegal;
    }

    /**
     * Set nomCommercial
     *
     * @param string $nomCommercial
     *
     * @return medicament
     */
    public function setNomCommercial($nomCommercial)
    {
        $this->nomCommercial = $nomCommercial;

        return $this;
    }

    /**
     * Get nomCommercial
     *
     * @return string
     */
    public function getNomCommercial()
    {
        return $this->nomCommercial;
    }

    /**
     * Set effets
     *
     * @param string $effets
     *
     * @return medicament
     */
    public function setEffets($effets)
    {
        $this->effets = $effets;

        return $this;
    }

    /**
     * Get effets
     *
     * @return string
     */
    public function getEffets()
    {
        return $this->effets;
    }

    /**
     * Set contreIndication
     *
     * @param string $contreIndication
     *
     * @return medicament
     */
    public function setContreIndication($contreIndication)
    {
        $this->contreIndication = $contreIndication;

        return $this;
    }

    /**
     * Get contreIndication
     *
     * @return string
     */
    public function getContreIndication()
    {
        return $this->contreIndication;
    }

    /**
     * Set prixEchantillon
     *
     * @param string $prixEchantillon
     *
     * @return medicament
     */
    public function setPrixEchantillon($prixEchantillon)
    {
        $this->prixEchantillon = $prixEchantillon;

        return $this;
    }

    /**
     * Get prixEchantillon
     *
     * @return string
     */
    public function getPrixEchantillon()
    {
        return $this->prixEchantillon;
    }
}

