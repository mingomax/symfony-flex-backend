<?php
declare(strict_types=1);
/**
 * /src/Rest/ControllerInterface.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Rest;

/**
 * Interface ControllerInterface
 *
 * @package App\Rest
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
interface ControllerInterface
{
    /**
     * @return ResourceInterface
     */
    public function getResource(): ResourceInterface;

    /**
     * @return ResponseHandlerInterface
     */
    public function getResponseHandler(): ResponseHandlerInterface;
}
