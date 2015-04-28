<?php

namespace Rych\Plates\Extension;

use League\Plates\Extension\ExtensionInterface;
use Symfony\Component\Security\Acl\Voter\FieldVote;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityExtension implements ExtensionInterface
{

    private $context;

    public function __construct(SecurityContextInterface $context = null)
    {
        $this->context = $context;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('is_granted', [ $this, 'getIsGranted' ]);
    }

    public function getIsGranted($role, $object = null, $field = null)
    {
        if (null === $this->context) {
            return false;
        }

        if (null !== $field) {
            $object = new FieldVote($object, $field);
        }

        return $this->context->isGranted($role, $object);
    }

}

