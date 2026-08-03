<?php
namespace App\Core\Base\Service;

use App\Domain\Core\Base\Repository\BaseRepository;
use Exception;

abstract class BaseService
{
    /**
     * BaseService constructor.
     * @param BaseRepository $repository
     * @throws Exception
     */
    public function __construct(private readonly BaseRepository $repository)
    {
    }
}
