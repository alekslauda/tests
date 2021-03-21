<?php

use app\Models\Contact\Factory as ContactsFactory;
use app\Models\Contact\Repository;
use app\Models\Contact\Service;
use app\Services\Core\ServiceLocator;
use app\Models\FileStructure\Repository as FileStructureRepository;
use app\Models\FileStructure\Service as FileStructureService;

$locator = ServiceLocator::getInstance();

$fileStructureRepository = new FileStructureRepository();
$fileStructureRepository->createTable();
$fileStructureService = new FileStructureService($fileStructureRepository);

$contactsFactory = new ContactsFactory();
$contactsFileRepository = new Repository($contactsFactory);
$contactsFileService = new Service($contactsFileRepository);

$locator->addService($contactsFileService);
$locator->addService($fileStructureService);
