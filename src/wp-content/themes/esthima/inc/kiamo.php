<?php
/*
 * This file is part of La Compagnie des Vétérinaires package.
 *
 * (c) Direction des Systèmes d'Information <service.informatique@cie-veterinaires.fr>
 *
 */

namespace App\Services;

/**
 * Class Kiamo
 */
class Kiamo
{

    private $sKiamoEndpoint;

    private $sKiamoToken;

    private $iKiamoCallbackId;

    /**
     * Kiamo constructor.
     *
     * @param EntitiesInterface $oEntitiesService
     * @param string            $sKiamoToken
     * @param integer           $iKiamoCallbackId
     */
    public function __construct(
        string $sKiamoEndpoint,
        string $sKiamoToken,
        int $iKiamoCallbackId
    ) {
        $this->sKiamoEndpoint = $sKiamoEndpoint;
        $this->sKiamoToken = $sKiamoToken;
        $this->iKiamoCallbackId = $iKiamoCallbackId;
    }

    /**
     * {@inheritDoc}
     */
    public function isRewind($sPhone): bool
    {
        $oCurl = curl_init($this->sKiamoEndpoint.'interactions/calls?phone_number='.$sPhone.'&states=wait&service_ids='.$this->iKiamoCallbackId);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLINFO_HEADER_OUT, true);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Kiamo-Api-Token: '.$this->sKiamoToken,
        ]);

        $sResponse = curl_exec($oCurl);
        $sError    = curl_error($oCurl);
        $iErrno    = curl_errno($oCurl);

        if (is_resource($oCurl)) {
            curl_close($oCurl);
        }

        if (0 !== $iErrno) {
            throw new \Exception($sError, $iErrno);
        }

        $oResponse = json_decode($sResponse);
        if (property_exists($oResponse, 'error')) {
            throw new \Exception($oResponse->error->message);
        }

        if (count($oResponse->data) > 0) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function postRewind($aRequest)
    {
        $oEntity = $this->oEntitiesService->getEntityByPostalCode(substr($aRequest['postalCode'], 0, 2));
        $oJson = json_encode([[
            'destination' =>  $aRequest['phone'],
            'userdata' => [
                'NumeroPresente' => $oEntity->getAddress()->getPhone(),
                'SF_contactAgence' => $oEntity->getFunctionalId(),
                'CCKInteractionLabel' => $aRequest['lastname'],
                'CCKCompanyCid' => 4,
            ],
        ]]);

        $oCurl = curl_init($this->sKiamoEndpoint.'services/'.$this->iKiamoCallbackId.'/interactions');
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLINFO_HEADER_OUT, true);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $oJson);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Kiamo-Api-Token: '.$this->sKiamoToken,
        ]);

        $sResponse = curl_exec($oCurl);
        $sError    = curl_error($oCurl);
        $iErrno    = curl_errno($oCurl);

        if (is_resource($oCurl)) {
            curl_close($oCurl);
        }

        if (0 !== $iErrno) {
            throw new \Exception($sError, $iErrno);
        }

        $oResponse = json_decode($sResponse);
        if (property_exists($oResponse, 'error')) {
            throw new \Exception($oResponse->error->message);
        }
    }
}