<?php

namespace App\Elastica\Transformer;

use App\Entity\Identification;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use stdClass;

/**
 * Transforms <code>Table</code> entity instances into elastica
 * <code>Document</code> instances.
 *
 * @package App\Elastica\Transformer
 */
class TableToElasticaTransformer implements ModelToElasticaTransformerInterface
{

    /**
     * @inheritdoc
     */
    public function transform($table, array $fields): Document
    {
        return new Document($table->getId(), $this->buildData($table));
    }

    protected function buildData($table): array
    {
        $data = [];
        $tableIdentifications = [];

        // VL USER
        $u = $table->getOwner();
        $vlUser = (object)array(
            'id' => $u->getId(),
            'firstName' => $u->getFirstName(),
            'lastName' => $u->getLastName(),
            'username' => $u->getUsername(),
            'email' => $u->getEmail()
        );

        // VL Table Identification
        $inlineTableIdentifications = '';
        foreach($table->getIdentifications() as $identification) {
            $ident = array(
                'id' => $identification->getId(),
                'createdAt' => $identification->getCreatedAt() ? $identification->getCreatedAt()->format('Y-m-d H:i:s') : null,
                'owner' => $vlUser,
                'updatedBy' => $identification->getUpdatedBy(),
                'updatedAt' => $identification->getUpdatedAt() ? $identification->getUpdatedAt()->format('Y-m-d H:i:s') : null,
                'repository' => $identification->getRepository(),
                'repositoryIdNomen' => $identification->getRepositoryIdNomen(),
                'repositoryIdTaxo' => $identification->getRepositoryIdTaxo(),
                'citationName' => $identification->getCitationName(),
                'nomenclaturalName' => $identification->getNomenclaturalName(),
                'taxonomicalName' => $identification->getTaxonomicalName(),
                'userIdIdentification' => $identification->getOwner()->getId()
            );
            $tableIdentifications[] = $ident;
            if ($identification->getRepository() && $identification->getRepositoryIdTaxo()) {
                $inlineTableIdentifications .= $identification->getRepository() . '~' . $identification->getRepositoryIdTaxo() . ' ';
            }
        }

        $data['id']               = $table->getId();
        $data['isDiagnosis']      = $table->getIsDiagnosis();

        $data['title']            = $table->getTitle();
        $data['description']      = $table->getDescription();

        $data['bibliographySourceId'] = $table->getVlBiblioSource() ? $table->getVlBiblioSource()->getId() : null;
        $data['hasPdf']           = (null !== $table->getPdf()) ? true : false;
        $data['pdfContentUrl']    = (null !== $table->getPdf()) ? $table->getPdf()->getContentUrl() : null;

        $data['userId']           = $u->getId();
        $date['userPseudo']       = $u->getUserPseudo();
        $data['user']             = $vlUser;

        $data['createdBy']        = $table->getCreatedBy();
        $data['createdAt']        = $this->getFormattedDate($table->getCreatedAt());
        $data['updatedBy']        = $table->getUpdatedBy();
        $data['updatedAt']        = $this->getFormattedDate($table->getUpdatedAt());

        $data['identifications']      = $tableIdentifications;
        $data['tableIdentification'] = $inlineTableIdentifications;
        // $data['syeIdentifications']   = $this->getSyeIdentifications($table->getSye());
        $data['occurrencesAndSyeIdentifications']  = $this->getSyeAndOccurrencesIdentifications($table->getSye());
        $data['rowsIdentifications']  = $this->getRowsIdentifications($table);

        $data['tableName']        = (null !== $table->getIdentifications()[0]) ? $table->getIdentifications()[0]->getTaxonomicalName() : '';
        $data['occurrencesNames'] = $this->getOccurrencesNames($table);

        $data['syeCount']         = count($table->getSye());
        $data['rowsCount']        = $this->getRowsCount($table);
        $data['occurrencesCount'] = $this->getOccurrencesCount($table);

        $data['allIdentifications']   = $this->getIdentifications($table);

        $data['vlBiblioSource']   = $table->getVlBiblioSource() ? $table->getVlBiblioSource()->getId().'~'.$table->getVlBiblioSource()->getTitle() : null;

        $data['preview']          = $this->getTablePreview($table);

        $data['vlWorkspace']      = $table->getVlWorkspace();

        return $data;
    }

    private function getFormattedDate(?\DateTimeInterface $date): ?string
    {
        return  (null !== $date) ? $date->format('Y-m-d H:i:s') : null;
    }

    private function getTableIdentification(?Identification $identification): ?string
    {
        if (null === $identification) return '';
        return $identification->getRepository() . '~' . $identification->getRepositoryIdTaxo();
    }

    private function getSyeIdentifications($syes): ?string
    {
        $flatIdentifications = '';

        if (null === $syes) return '';

        foreach ($syes as $sye) {
            if (null !== $sye->getIdentifications()) {
                foreach($sye->getIdentifications() as $syeIdentification) {
                    $i = 0;
                    $flatIdentification = $syeIdentification->getRepository() . '~' . $syeIdentification->getRepositoryIdTaxo();
                    if ($i === 0) { $flatIdentifications = $flatIdentification; } elseif ($i > 0) { $flatIdentifications = $flatIdentifications . ' ' . $flatIdentification; }
                    $i++;
                }
            }
        }

        return $flatIdentifications;


    }

    /**
     * Returns a flat identifications string that contains every SYE AND idiotaxons identifications
     */
    private function getSyeAndOccurrencesIdentifications($syes): ?string
    {
        $flatIdentifications = '';

        if (null === $syes) return '';

        $i = 0;
        foreach ($syes as $sye) {
            $syeIdentifications = $sye->getIdentifications();
            if (null !== $syeIdentifications) {
                foreach ($syeIdentifications as $syeIdentification) {
                    $flatIdentificationSye = $syeIdentification->getRepository() . '~' . $syeIdentification->getRepositoryIdTaxo();
                    $flatIdentifications .= $flatIdentificationSye . ' ';
                }
            }
            // $flatIdentification = $this->getOccurrencesIdentifications($sye->getOccurrences());
            // if ($i === 0) { $flatIdentifications = $flatIdentification; } elseif ($i > 0) { $flatIdentifications = $flatIdentifications . ' ' . $flatIdentificationn; }

            foreach ($sye->getOccurrences() as $occ) {
                $occIdentifications = $occ->getIdentifications();
                if (null !== $occIdentifications) {
                    foreach ($occIdentifications as $occIdentification) {
                        $flatIdentificationOcc = $occIdentification->getRepository() . '~' . $occIdentification->getRepositoryIdTaxo();
                        $flatIdentifications .= $flatIdentificationOcc . ' ';
                        // $i++;
                    }
                }
            }
            // $i++;
        }

        return $flatIdentifications;
    }

    private function getSyeOccurrencesIdentifications($syes): ?string
    {
        $flatIdentifications = '';

        if (null === $syes) return '';

        foreach ($syes as $sye) {
            $i = 0;
            $flatIdentification = $this->getOccurrencesIdentifications($sye->getOccurrences());
            if ($i === 0) { $flatIdentifications = $flatIdentification; } elseif ($i > 0) { $flatIdentifications = $flatIdentifications . ' ' . $flatIdentification; }
            $i++;
        }

        return $flatIdentifications;
    }

    private function getOccurrencesIdentifications($occurrences): ?string
    {
        $flatIdentifications = '';

        if (null === $occurrences) return '';

        foreach ($occurrences as $occ) {
            $occIdentifications = $occ->getIdentifications();
            if (null !== $occIdentifications) {
                foreach ($occIdentifications as $occIdentification) {
                    $i = 0;
                    $flatIdentification = $occIdentification->getRepository() . '~' . $occIdentification->getRepositoryIdTaxo();
                    $flatIdentifications .= $flatIdentification . ' ';
                    $i++;
                }
            }
        }

        return $flatIdentifications;
    }

    private function getRowsIdentifications($table): ?string {
        $flatIdentifications = '';

        if (null === $table) return '';

        $tableRowDef = $table->getRowsDefinition();

        if (null === $tableRowDef) return '';

        $i = 0;
        foreach ($tableRowDef as $rowDef) {
            if ('data' === $rowDef->getType()) {
                $flatIdentification = $rowDef->getRepository() . '~' . $rowDef->getRepositoryIdTaxo();
                if ($i === 0) { $flatIdentifications = $flatIdentification; } elseif ($i > 0) { $flatIdentifications = $flatIdentifications . ' ' . $flatIdentification; }
                $i++;
            }
        }

        return $flatIdentifications;
    }

    private function getTablePreview($table): array
    {
        $rowsDef = $table->getRowsDefinition();
        $syntheticCol = $table->getSyntheticColumn()->getItems();

        $rows = [];

        $i = 0;
        $j = 0;
        foreach ($rowsDef as $rowDef) {
            if ($rowDef->getType() === 'group') {
                $rows[$i] = $rowDef->getDisplayName();
            } elseif ($rowDef->getType() === 'data') {
                $rows[$i] = $rowDef->getDisplayName();
                try {
                    $rows[$i] .= '~' . $syntheticCol[$j]->getCoef();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $j++;
            }
            $i++;
        }

        return $rows;
    }

    private function getIdentifications($_table) {
        $identifications = new stdClass();

        $tableId = $_table->getId();
        $tableIdentifications = $_table->getIdentifications();

        $table = new stdClass();
        $table->id = $tableId;
        $table->identifications = $tableIdentifications;

        $syes = array();
        foreach ($_table->getSye() as $sye) {
            $syeId          = $sye->getId();
            $syeIdentifications = $sye->getIdentifications();
            $syeReleves     = $sye->getOccurrences();

            $releves = array();

            foreach ($syeReleves as $syeReleve) {
                $releve = new stdClass();
                $releve->id = $syeReleve->getId();
                $releve->identifications = $syeReleve->getIdentifications();
                $releves[] = $releve;
            }

            $sye = new stdClass();
            $sye->id = $syeId;
            $sye->identifications = $syeIdentifications;
            $sye->releves = $releves;

            $syes[] = $sye;
        }

        $identifications->table = $table;
        $identifications->syes  = $syes;

        return $identifications; // json_encode($identifications);
    }

    private function getOccurrencesCount($table): ?int {
        if (null === $table) return 0;
        $syes = $table->getSye();
        if (null === $syes) return 0;

        $count = 0;
        foreach ($syes as $sye) {
            $count += count($sye->getOccurrences());
        }

        return $count;
    }

    private function getRowsCount($table): ?int {
        if (null === $table) return 0;
        $rowsDef = $table->getRowsDefinition();
        if (null === $rowsDef) return 0;

        $count = 0;
        foreach ($rowsDef as $rowDef) {
            if ($rowDef->getType() === 'data') $count++;
        }

        return $count;
    }

    private function getOccurrencesNames($table): array
    {
        if (null === $table) return [];
        $syes = $table->getSye();
        if (null === $syes) return [];

        $ident = array();
        foreach ($syes as $sye) {
            $occurrences = $sye->getOccurrences();
            foreach ($occurrences as $occ) {
                $identification = $occ->getIdentifications()[0];
                if (null !== $identification) $ident[] = $identification->getTaxonomicalName();
            }
        }

        return $ident;
    }
}
