<?php

namespace Ds\Bundle\RecordBundle\DataFixtures\ORM;

use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Bundle\RecordBundle\Entity\Record;
use Ds\Bundle\RecordBundle\Entity\RecordAssociation;

/**
 * Class LoadRecordAssociationData
 */
class LoadRecordAssociationData extends ResourceFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $recordAssociations = $this->parse(__DIR__.'/../../Resources/data/{server}/record_associations.yml');

        foreach ($recordAssociations as $recordAssociation) {
            $entity = new RecordAssociation;
            $entity
                ->setRecord($manager->getRepository(Record::class)->findOneBy(['uuid' => $recordAssociation['record']]))
                ->setUuid($recordAssociation['uuid'])
                ->setEntity($recordAssociation['entity'])
                ->setEntityUuid($recordAssociation['entity_uuid'])
                ->setOwner($recordAssociation['owner'])
                ->setOwnerUuid($recordAssociation['owner_uuid']);
            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
