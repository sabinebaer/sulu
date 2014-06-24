<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Sulu\Bundle\MediaBundle\Entity\Media;

/**
 * MediaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MediaRepository extends EntityRepository
{
    /**
     * Get Media by id
     * @param $id
     * @param bool $asArray
     * @return mixed|Media
     */
    public function findMediaById($id, $asArray = false)
    {
        try {
            $qb = $this->createQueryBuilder('media')
                ->leftJoin('media.type', 'type')
                ->leftJoin('media.collection', 'collection')
                ->leftJoin('media.files', 'file')
                ->leftJoin('file.fileVersions', 'fileVersion')
                ->leftJoin('fileVersion.tags', 'tag')
                ->leftJoin('fileVersion.meta', 'fileVersionMeta')
                ->leftJoin('fileVersion.contentLanguages', 'fileVersionContentLanguage')
                ->leftJoin('fileVersion.publishLanguages', 'fileVersionPublishLanguage')
                /*
                ->leftJoin('media.creator', 'creator')
                ->leftJoin('creator.contact', 'creatorContact')
                ->leftJoin('media.changer', 'changer')
                ->leftJoin('changer.contact', 'changerContact')
                */
                ->addSelect('type')
                ->addSelect('collection')
                ->addSelect('file')
                ->addSelect('tag')
                ->addSelect('fileVersion')
                ->addSelect('fileVersionMeta')
                ->addSelect('fileVersionContentLanguage')
                ->addSelect('fileVersionPublishLanguage')
                /*
                ->addSelect('creator')
                ->addSelect('changer')
                ->addSelect('creatorContact')
                ->addSelect('changerContact')
                */
                ->where('media.id = :mediaId');

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            $query->setParameter('mediaId', $id);

            if ($asArray) {
                if (isset($query->getArrayResult()[0])) {
                    return $query->getArrayResult()[0];
                } else {
                    return null;
                }
            } else {
                return $query->getSingleResult();
            }
        } catch (NoResultException $ex) {
            return null;
        }
    }

    /**
     * Get medias by ids
     * @param string[] $ids
     * @param bool $asArray
     * @return Media[]|array
     */
    public function findMediaByIds($ids, $asArray = false)
    {
        if (empty($ids)) {
            return array();
        }

        try {
            $qb = $this->createQueryBuilder('media')
                ->leftJoin('media.type', 'type')
                ->leftJoin('media.collection', 'collection')
                ->leftJoin('media.files', 'file')
                ->leftJoin('file.fileVersions', 'fileVersion')
                ->leftJoin('fileVersion.tags', 'tag')
                ->leftJoin('fileVersion.meta', 'fileVersionMeta')
                ->leftJoin('fileVersion.contentLanguages', 'fileVersionContentLanguage')
                ->leftJoin('fileVersion.publishLanguages', 'fileVersionPublishLanguage')
                /*
                ->leftJoin('media.creator', 'creator')
                ->leftJoin('creator.contact', 'creatorContact')
                ->leftJoin('media.changer', 'changer')
                ->leftJoin('changer.contact', 'changerContact')
                */
                ->addSelect('type')
                ->addSelect('collection')
                ->addSelect('file')
                ->addSelect('tag')
                ->addSelect('fileVersion')
                ->addSelect('fileVersionMeta')
                ->addSelect('fileVersionContentLanguage')
                ->addSelect('fileVersionPublishLanguage')
                /*
                ->addSelect('creator')
                ->addSelect('changer')
                ->addSelect('creatorContact')
                ->addSelect('changerContact')
                */
                ->where('media.id IN (:mediaIds)');

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            $query->setParameter('mediaIds', $ids);

            if ($asArray) {
                return $query->getArrayResult();
            } else {
                return $query->getResult();
            }
        } catch (NoResultException $ex) {
            return null;
        }
    }

    /**
     * returns media filtered by collection
     */
    public function findMedia($collection = null, $ids = null, $limit = null)
    {
        try {
            $qb = $this->createQueryBuilder('media')
                ->leftJoin('media.type', 'type')
                ->leftJoin('media.collection', 'collection')
                ->leftJoin('media.files', 'file')
                ->leftJoin('file.fileVersions', 'fileVersion')
                ->leftJoin('fileVersion.tags', 'tag')
                ->leftJoin('fileVersion.meta', 'fileVersionMeta')
                ->leftJoin('fileVersion.contentLanguages', 'fileVersionContentLanguage')
                ->leftJoin('fileVersion.publishLanguages', 'fileVersionPublishLanguage')
                /*
                ->leftJoin('media.creator', 'creator')
                ->leftJoin('creator.contact', 'creatorContact')
                ->leftJoin('media.changer', 'changer')
                ->leftJoin('changer.contact', 'changerContact')
                */
                ->addSelect('type')
                ->addSelect('collection')
                ->addSelect('file')
                ->addSelect('tag')
                ->addSelect('fileVersion')
                ->addSelect('fileVersionMeta')
                ->addSelect('fileVersionContentLanguage')
                ->addSelect('fileVersionPublishLanguage')
                /*
                ->addSelect('creator')
                ->addSelect('changer')
                ->addSelect('creatorContact')
                ->addSelect('changerContact')*/;

            if ($ids !== null) {
                $qb->where('media.id IN (:mediaIds)');
            }

            if ($collection !== null) {
                $qb->where('collection.id = :collection');
            }

            if ($limit !== null) {
                $qb->setMaxResults($limit);
            }

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            if ($collection !== null) {
                $query->setParameter('collection', $collection);
            }
            if ($ids !== null) {
                $query->setParameter('mediaIds', $ids);
            }

            return $query->getArrayResult();
        } catch (NoResultException $ex) {
            return null;
        }
    }

    /**
     * finds all Media but only selects given fields
     * @param array $fields
     * @return array
     */
    public function findAllSelect($fields = array())
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->from($this->getEntityName(), 'media');

        foreach ($fields as $field) {
            $qb->addSelect('media.' . $field . ' AS ' . $field);
        }

        $query = $qb->getQuery();
        $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $query->getArrayResult();
    }

    /**
     * Get Media by id to delete
     * @param $id
     * @return mixed|Media
     */
    public function findMediaByIdForDelete($id)
    {
        try {
            $qb = $this->createQueryBuilder('media')
                ->leftJoin('media.files', 'file')
                ->leftJoin('file.fileVersions', 'fileVersion')
                ->addSelect('file')
                ->addSelect('fileVersion')
                ->where('media.id = :mediaId');

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            $query->setParameter('mediaId', $id);

            return $query->getSingleResult();
        } catch (NoResultException $ex) {
            return null;
        }
    }
}
