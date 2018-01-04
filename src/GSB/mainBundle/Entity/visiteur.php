<?php

namespace GSB\mainBundle\Entity;

/**
 * visiteur
 */
class visiteur
{
    /**
     * @var int
     */
    private $idVisiteur;

    /**
     * @var int
     */
    private $idLaboratoire;

    /**
     * @var int
     */
    private $idSecteur;

    /**
     * @var string
     */
    private $nomVisiteur;

    /**
     * @var string
     */
    private $prenomVisiteur;

    /**
     * @var string
     */
    private $adresseVisiteur;

    /**
     * @var string
     */
    private $cpVisiteur;

    /**
     * @var string
     */
    private $villeVisiteur;

    /**
     * @var \DateTime
     */
    private $dateEmbauche;

    /**
     * @var string
     */
    private $loginVisiteur;

    /**
     * @var string
     */
    private $pwdVisiteur;

    /**
     * @var string
     */
    private $typeVisiteur;

    /**
     * Set idVisiteur
     *
     * @param integer $idVisiteur
     *
     * @return visiteur
     */
    public function setIdVisiteur($idVisiteur)
    {
        $this->idVisiteur = $idVisiteur;

        return $this;
    }

    /**
     * Get idVisiteur
     *
     * @return int
     */
    public function getIdVisiteur()
    {
        return $this->idVisiteur;
    }

    /**
     * Set idLaboratoire
     *
     * @param integer $idLaboratoire
     *
     * @return visiteur
     */
    public function setIdLaboratoire($idLaboratoire)
    {
        $this->idLaboratoire = $idLaboratoire;

        return $this;
    }

    /**
     * Get idLaboratoire
     *
     * @return int
     */
    public function getIdLaboratoire()
    {
        return $this->idLaboratoire;
    }

    /**
     * Set idSecteur
     *
     * @param integer $idSecteur
     *
     * @return visiteur
     */
    public function setIdSecteur($idSecteur)
    {
        $this->idSecteur = $idSecteur;

        return $this;
    }

    /**
     * Get idSecteur
     *
     * @return int
     */
    public function getIdSecteur()
    {
        return $this->idSecteur;
    }

    /**
     * Set nomVisiteur
     *
     * @param string $nomVisiteur
     *
     * @return visiteur
     */
    public function setNomVisiteur($nomVisiteur)
    {
        $this->nomVisiteur = $nomVisiteur;

        return $this;
    }

    /**
     * Get nomVisiteur
     *
     * @return string
     */
    public function getNomVisiteur()
    {
        return $this->nomVisiteur;
    }

    /**
     * Set prenomVisiteur
     *
     * @param string $prenomVisiteur
     *
     * @return visiteur
     */
    public function setPrenomVisiteur($prenomVisiteur)
    {
        $this->prenomVisiteur = $prenomVisiteur;

        return $this;
    }

    /**
     * Get prenomVisiteur
     *
     * @return string
     */
    public function getPrenomVisiteur()
    {
        return $this->prenomVisiteur;
    }

    /**
     * Set adresseVisiteur
     *
     * @param string $adresseVisiteur
     *
     * @return visiteur
     */
    public function setAdresseVisiteur($adresseVisiteur)
    {
        $this->adresseVisiteur = $adresseVisiteur;

        return $this;
    }

    /**
     * Get adresseVisiteur
     *
     * @return string
     */
    public function getAdresseVisiteur()
    {
        return $this->adresseVisiteur;
    }

    /**
     * Set cpVisiteur
     *
     * @param string $cpVisiteur
     *
     * @return visiteur
     */
    public function setCpVisiteur($cpVisiteur)
    {
        $this->cpVisiteur = $cpVisiteur;

        return $this;
    }

    /**
     * Get cpVisiteur
     *
     * @return string
     */
    public function getCpVisiteur()
    {
        return $this->cpVisiteur;
    }

    /**
     * Set villeVisiteur
     *
     * @param string $villeVisiteur
     *
     * @return visiteur
     */
    public function setVilleVisiteur($villeVisiteur)
    {
        $this->villeVisiteur = $villeVisiteur;

        return $this;
    }

    /**
     * Get villeVisiteur
     *
     * @return string
     */
    public function getVilleVisiteur()
    {
        return $this->villeVisiteur;
    }

    /**
     * Set dateEmbauche
     *
     * @param \DateTime $dateEmbauche
     *
     * @return visiteur
     */
    public function setDateEmbauche($dateEmbauche)
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * Get dateEmbauche
     *
     * @return \DateTime
     */
    public function getDateEmbauche()
    {
        return $this->dateEmbauche;
    }

    /**
     * Set loginVisiteur
     *
     * @param string $loginVisiteur
     *
     * @return visiteur
     */
    public function setLoginVisiteur($loginVisiteur)
    {
        $this->loginVisiteur = $loginVisiteur;

        return $this;
    }

    /**
     * Get loginVisiteur
     *
     * @return string
     */
    public function getLoginVisiteur()
    {
        return $this->loginVisiteur;
    }

    /**
     * Set pwdVisiteur
     *
     * @param string $pwdVisiteur
     *
     * @return visiteur
     */
    public function setPwdVisiteur($pwdVisiteur)
    {
        $this->pwdVisiteur = $pwdVisiteur;

        return $this;
    }

    /**
     * Get pwdVisiteur
     *
     * @return string
     */
    public function getPwdVisiteur()
    {
        return $this->pwdVisiteur;
    }

    /**
     * Set typeVisiteur
     *
     * @param string $typeVisiteur
     *
     * @return visiteur
     */
    public function setTypeVisiteur($typeVisiteur)
    {
        $this->typeVisiteur = $typeVisiteur;

        return $this;
    }

    /**
     * Get typeVisiteur
     *
     * @return string
     */
    public function getTypeVisiteur()
    {
        return $this->typeVisiteur;
    }
}

