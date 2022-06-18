<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Contracts\SenderInterface;
use App\Entity\Mail;
use App\Services\MailgunService;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private SenderInterface $sender,
        private ContextAwareDataPersisterInterface $decorated
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = []): Mail
    {
        $result = $this->decorated->persist($data, $context);

        if (
            $result instanceof Mail
        ) {
            $this->sender->send(
                $result->getShipper(),
                'contact@forelse.info',
                $result->getSubject(),
                $result->getText()
            );
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}