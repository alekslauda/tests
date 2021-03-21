<?php

use app\Models\Contact\Factory as ContactsFactory;
use app\Models\Contact\Repository;
use app\Models\Contact\Service;
use app\Services\Core\ServiceLocator;

$locator = ServiceLocator::getInstance();

$contactsFactory = new ContactsFactory();
$contactsFileRepository = new Repository($contactsFactory);
$contactsFileService = new Service($contactsFileRepository);

$locator->addService($contactsFileService);
