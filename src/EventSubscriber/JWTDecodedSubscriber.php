<?php
declare(strict_types = 1);
/**
 * /src/EventSubscriber/JWTDecodedSubscriber.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\EventSubscriber;

use App\Helpers\LoggerAwareTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class JWTDecodedSubscriber
 *
 * @package App\EventSubscriber
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class JWTDecodedSubscriber
{
    // Traits
    use LoggerAwareTrait;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * JWTDecodedSubscriber constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Subscriber method to make some custom JWT payload checks.
     *
     * This method is called when 'lexik_jwt_authentication.on_jwt_decoded' event is broadcast.
     *
     * @param JWTDecodedEvent $event
     */
    public function onJWTDecoded(JWTDecodedEvent $event): void
    {
        // No need to continue event is invalid
        if (!$event->isValid()) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();

        $this->checkPayload($event, $request);

        if ($request === null) {
            $this->logger->error('Request not available');

            $event->markAsInvalid();
        }
    }

    /**
     * Method to check payload data.
     *
     * @param JWTDecodedEvent $event
     * @param Request|null    $request
     */
    private function checkPayload(JWTDecodedEvent $event, Request $request = null): void
    {
        if ($request === null) {
            return;
        }

        $payload = $event->getPayload();

        // Get bits for checksum calculation
        $bits = [
            $request->getClientIp(),
            $request->headers->get('User-Agent'),
        ];

        // Calculate checksum
        $checksum = \hash('sha512', \implode('|', $bits));

        // Custom checks to validate user's JWT
        if (!\array_key_exists('checksum', $payload) || $payload['checksum'] !== $checksum) {
            $event->markAsInvalid();
        }
    }
}
