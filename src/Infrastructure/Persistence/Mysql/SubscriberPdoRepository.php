<?php

namespace App\Infrastructure\Persistence\Mysql;

use PDOException;
use App\Domain\Entities\Subscriber;
use App\Domain\Interfaces\Repositories\SubscriberRepository;

class SubscriberPdoRepository extends PdoAbstractRepository implements SubscriberRepository
{

    /**
     * @param Subscriber $subscriber
     * @throws PDOException
     * @return void
     */
    public function create(Subscriber $subscriber): bool
    {
        $data = [
            'id'           => $subscriber->getId(),
            'email'        => $subscriber->getEmail(),
            'status'       => $subscriber->getStatus(),
            'subscribedAt' => $subscriber->getSubscribedAt(),
        ];
        $sql = "INSERT INTO subscriber (id, email, status, subscribed_at) VALUES (:id, :email, :status, :subscribedAt)";
        return $this->executeSQL($sql, $data);
    }

    /**
     * @param Subscriber $subscriber
     * @throws PDOException
     * @return bool
     */
    public function edit(Subscriber $subscriber): bool
    {
        $data = [
            'id'             => $subscriber->getId(),
            'email'          => $subscriber->getEmail(),
            'status'         => $subscriber->getStatus(),
            'total'          => $subscriber->getTotal(),
            'subscribedAt'   => $subscriber->getSubscribedAt(),
            'unsubscribedAt' => $subscriber->getUnsubscribedAt(),
        ];
        $sql = "UPDATE subscriber SET email=:email, status=:status, total=:total, subscribed_at=:subscribedAt, unsubscribed_at=:unsubscribedAt WHERE id = :id";
        return $this->executeSQL($sql, $data);
    }


    /**
     * @param int $id
     * @throws PDOException
     * @return Subscriber|null
     */
    public function getById(int $id): ?Subscriber
    {
        $sql = "SELECT * from subscriber WHERE id = :id AND status != 'DELETED' ";
        $result = $this->query($sql, ['id' => $id]);
        if ($result) {
            return new Subscriber(
                $result['id'],
                $result['email'],
                $result['status'],
                $result['subscribed_at'],
                $result['unsubscribed_at']
            );
        }
        return null;
    }
}
