<?php

namespace App\Elastica\Transformer;

use App\Entity\Occurrence;
use App\Entity\User;
use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;

/**
 * Transforms <code>Occurrence</code> entity instances into elastica
 * <code>Document</code> instances.
 *
 * @package App\Elastica\Transformer
 */
class OccurrenceToElasticaTransformer implements ModelToElasticaTransformerInterface {

    /**
     * @inheritdoc
     */
    public function transform($occ, array $fields): Document {
        return new Document($occ->getId(), $this->buildData($occ));
    }

    protected function buildData(Occurrence $occ) {
        // The document to be built based on provided Occurrence:
        $data = [];
        $tags = [];
        $childrenIds = [];
        $identifications = [];
        $flatIdentifications = '';
        $flatChildrenIdentifications = '';
        $childrenPreview = [];
        $ExtendedFieldValues = [];
        $vlObservers = [];
        $flatVlObservers = '';

        // VL USER
        $u = $occ->getOwner();
        /** @var $vlUser User */
        $vlUser = (object)array(
            'id' => $u->getId(),
            'firstName' => $u->getFirstName(),
            'lastName' => $u->getLastName(),
            'email' => $u->getEmail()
        );

        // VL Identification
        foreach($occ->getIdentifications() as $identification) {
            $v = array(
                'id' => $identification->getId(),
                'createdAt' => $identification->getCreatedAt() ? $identification->getCreatedAt()->format('Y-m-d H:i:s') : null,
                'user' => $vlUser,
                'updatedBy' => $identification->getUpdatedBy(),
                'updatedAt' => $identification->getUpdatedAt() ? $identification->getUpdatedAt()->format('Y-m-d H:i:s') : null,
                'repository' => $identification->getRepository(),
                'repositoryIdNomen' => $identification->getRepositoryIdNomen(),
                'repositoryIdTaxo' => $identification->getRepositoryIdTaxo(),
                'citationName' => $identification->getCitationName(),
                'nomenclaturalName' => $identification->getNomenclaturalName(),
                'taxonomicalName' => $identification->getTaxonomicalName()
            );
            $identifications[] = $v;
        }

        // VL Flat identification
        $i = 0;
        foreach($occ->getIdentifications() as $identification) {
            $flatIdentification = $identification->getRepository() . '~' . $identification->getRepositoryIdTaxo();
            if ($i === 0) { $flatIdentifications = $flatIdentification; } elseif ($i > 0) { $flatIdentifications = $flatIdentifications . ' ' . $flatIdentification; }
            $i++;
        }

        // VL Children ids
        foreach($occ->getChildren() as $child) {
            $childrenIds[] = $child->getId();
        }

        /*
         * VL - children identifications
         * If occurrence level is 'microcenosis', we go through 2 levels depth
         * Else, one level is enough
         */
        if ($occ->getLevel() === 'microcenosis') {
            $i = 0;
            foreach ($occ->getChildren() as $child) {
                foreach($child->getIdentifications() as $childIdentification) {
                    $flatChildIdentification = $childIdentification->getRepository() . '~' . $childIdentification->getRepositoryIdTaxo();
                    if ($i === 0) { $flatChildrenIdentifications = $flatChildIdentification; } elseif ($i > 0) { $flatChildrenIdentifications = $flatChildrenIdentifications . ' ' . $flatChildIdentification; }
                    $i++;
                }
                foreach ($child->getChildren() as $grandChild) {
                    foreach ($grandChild->getIdentifications() as $grandChildIdentification) {
                        $flatGrandChildIdentification = $grandChildIdentification->getRepository() . '~' . $grandChildIdentification->getRepositoryIdTaxo();
                        $childrenPreview[] = array(
                            'layer' => $child->getLayer(),
                            'repo' => $grandChildIdentification->getRepository(),
                            'name' => $grandChildIdentification->getRepository() === 'otherunknown' ? $grandChildIdentification->getCitationName() : $grandChildIdentification->getTaxonomicalName(),
                            'coef' => $grandChild->getCoef());
                        if ($i === 0) { $flatChildrenIdentifications = $flatGrandChildIdentification; } elseif ($i > 0) { $flatChildrenIdentifications = $flatChildrenIdentifications . ' ' . $flatGrandChildIdentification; }
                        $i++;
                    }
                }
            }
        } else {
            $i = 0;
            foreach ($occ->getChildren() as $child) {
                foreach($child->getIdentifications() as $childIdentification) {
                    $flatChildIdentification = $childIdentification->getRepository() . '~' . $childIdentification->getRepositoryIdTaxo();
                    $childrenPreview[] = array(
                        'layer' => $occ->getLayer(),
                        'repo' => $childIdentification->getRepository(),
                        'name' => $childIdentification->getRepository() === 'otherunknown' ? $childIdentification->getCitationName() : $childIdentification->getTaxonomicalName(),
                        'coef' => $child->getCoef());
                    if ($i === 0) { $flatChildrenIdentifications = $flatChildIdentification; } elseif ($i > 0) { $flatChildrenIdentifications = $flatChildrenIdentifications . ' ' . $flatChildIdentification; }
                    $i++;
                }
            }
        }

        // VL ExtendedFieldValues builder
        // The purpose of this loop :
        //   whitout any mapping, elasticsearch would map any ExtendedField as a string
        //   but veglab uses ExtendedField as filters trough elasticsearch queries
        //   and an ES query must have typed fields (integer, float, date, ...)
        foreach($occ->getExtendedFieldOccurrences() as $extendedFieldOccurrence) {
            $dataType = $extendedFieldOccurrence->getExtendedField()->getDataType();

            $stringValue = $extendedFieldOccurrence->getValue();
            $integerValue = null;
            $floatValue = null;
            $dateValue = null;
            $booleanValue  = null;

            // Is numeric ?
            // @Todo use a ExtendedFieldDataTypeEnumType
            if ($dataType === 'Entier') {
                $integerValue = (int)$stringValue;
            }
            if ($dataType === 'Décimal') {
                $floatValue = (float)$stringValue;
            }

            // Is date ?
            if ($dataType === 'Date') {
                $dateArrayValues = explode('/', $stringValue);
                if (count($dateArrayValues) === 3) {
                    if (checkdate((int)$dateArrayValues[1], (int)$dateArrayValues[0], (int)$dateArrayValues[2])) {
                        $dateValue = $stringValue;
                    }
                }
            }

            // IS boolean ?
            if ($dataType === 'Booléen') {
                $booleanValue = $stringValue === 'true' ? true : false;
            }

            $value = array(
                'fieldId' => $extendedFieldOccurrence->getExtendedField()->getFieldId(),
                'value' => $stringValue,
                'integerValue' => $integerValue,
                'floatValue' => $floatValue,
                'dateValue' => $dateValue,
                'booleanValue' => $booleanValue
            );
            $ExtendedFieldValues[] = $value;
        }

        // VL Centroid
        // Pay attention : Centroid field is mapped as a geo_point into fos_elastica (see /config/packages/fos_elastica.yaml)
        //                 An ES Geo-point differs from a geoJson Point. Provided centroid value is a geoJson
        //                 ie : geoJson Point : { type: "Point", coordinates: [lng_integer, lat_integer] }
        //                      geo_point     : { lat: lat_integer, lon: lng_integer }
        //                                      OR "lat, lng"  <-- LAT/LNG inversed from geoJson specification
        //                                      OR [lng, lat]  <-- LNG/LAT : same order as geoJson spec.
        //                                      see https://www.elastic.co/guide/en/elasticsearch/reference/6.3/geo-point.html
        if ($occ->getCentroid() !== null) {
            $geojsonCentroid = json_decode($occ->getCentroid(), true);
            $data['centroid'] = [$geojsonCentroid['coordinates'][0], $geojsonCentroid['coordinates'][1]];
            // $data['esCentroid'] = json_encode(array("lat" => $geojsonCentroid['coordinates'][0], "lon" => $geojsonCentroid['coordinates'][1]));
        } else {
            $geometry = json_decode($occ->getGeometry(), true);
            if ($geometry && $geometry['type'] && $geometry['type'] === 'Point') {
                $data['centroid'] = [$geometry['coordinates'][0], $geometry['coordinates'][1]];
                //                                            |-> lng                      |-> lat
                // $data['esCentroid'] = json_encode(array("lat" => $geometry['coordinates'][1], "lon" => $geometry['coordinates'][0]));
                // $data['esCentroid'] = array($geometry['coordinates'][1], $geometry['coordinates'][0]);
            }
        }

        // VL observers
        $iVlObs = 0;
        foreach($occ->getVlObservers() as $occVlObserver) {
            $o = array(
                'id' => $occVlObserver->getId(),
                'name' => $occVlObserver->getName()
            );
            if (!empty($o)) {
                $vlObservers[] = $o;
                $flatVlObservers .= $o['id'] . '~' . $o['name'];
                if ($iVlObs < count($occ->getVlObservers()) - 1) { $flatVlObservers .= ', '; }
            }
            $iVlObs++;
        }

        $data['tags'] = $tags;
        $data['id'] = $occ->getId();
        $data['id_keyword'] = $occ->getId();
        $data['geometry'] = json_decode($occ->getGeometry());
        $data['userId'] = $occ->getUserId();
        $data['owner'] = $vlUser;
        $data['vlObservers']= $vlObservers;
        $data['flatVlObservers'] = $flatVlObservers;
        $dateObserved = $occ->getFormattedDateObserved();
        $data['dateObserved'] = $dateObserved;
        $data['dateObservedPrecision'] = $occ->getDateObservedPrecision();
        $data['dateObserved_keyword'] = $dateObserved;
        $data['dateObservedMonth'] = $occ->getDateObservedMonth();
        $data['dateObservedDay'] = $occ->getDateObservedDay();
        $data['dateObservedYear'] = $occ->getDateObservedYear();
        $data['dateCreated'] = $occ->getFormattedDateCreated();
        $data['dateCreated_keyword'] = $occ->getFormattedDateCreated();
        $data['dateUpdated'] = $occ->getFormattedDateUpdated();
        $data['datePublished'] = $occ->getFormattedDatePublished();
        $data['certainty'] = $occ->getCertainty();
        $data['certainty_keyword'] = $occ->getCertainty();
        $data['occurrenceType'] = $occ->getOccurrenceType();
        $data['coef'] = $occ->getCoef();
        $data['bibliographySourceId'] = $occ->getVlBiblioSource() ? $occ->getVlBiblioSource()->getId() : null;
        $data['vlBiblioSource'] = $occ->getVlBiblioSource() ? $occ->getVlBiblioSource()->getTitle() : null;
        $data['isPublic'] = $occ->getIsPublic();
        $data['isPublic_keyword'] = $occ->getIsPublic();
        $data['signature'] = $occ->getSignature();
        $data['elevation'] = $occ->getElevation();
        $data['isElevationEstimated'] = $occ->getIsElevationEstimated();
        $data['elevation_keyword'] = $occ->getElevation();
        $data['geodatum'] = $occ->getGeodatum();
        $data['locality'] = $occ->getLocality();
        $data['localityInseeCode'] = $occ->getLocalityInseeCode();
        $data['locality_keyword'] = $occ->getLocality();
        $data['publishedLocation'] = $occ->getPublishedLocation();
        $data['vlLocationAccuracy'] = $occ->getVlLocationAccuracy();
        $data['osmCounty'] = $occ->getOsmCounty();
        $data['osmState'] = $occ->getOsmState();
        $data['osmPostcode'] = $occ->getOsmPostcode();
        $data['osmCountry'] = $occ->getOsmCountry();
        $data['osmCountryCode'] = $occ->getOsmCountryCode();
        $data['osmId'] = $occ->getOsmId();
        $data['osmPlaceId'] = $occ->getOsmPlaceId();
        $data['level'] = $occ->getLevel();
        $data['parentId'] = null !== $occ->getParent() ? $occ->getParent()->getId() : null;
        $data['childrenIds'] = $childrenIds;
        $data['parentLevel'] = $occ->getParentLevel();
        $data['layer'] = $occ->getLayer();
        $data['identifications'] = $identifications;
        $data['flatIdentifications'] = $flatIdentifications;
        $data['flatChildrenIdentifications'] = $flatChildrenIdentifications;
        $data['childrenPreview'] = $childrenPreview;
        $data['extendedFieldValues'] = $ExtendedFieldValues;
        $data['vlWorkspace'] = $occ->getVlWorkspace();

        return $data;
    }


}
