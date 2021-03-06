<?php
declare(strict_types = 1);
/**
 * /src/Utils/Tests/RestTraitTestCase.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Utils\Tests;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestTraitTestCase
 *
 * @codeCoverageIgnore
 *
 * @package App\Utils\Tests
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
abstract class RestTraitTestCase extends WebTestCase
{
    private const END_POINT_COUNT = '/count';

    /**
     * @return array
     */
    abstract public function getValidUsers(): array;

    /**
     * @return array
     */
    abstract public function getInvalidUsers(): array;

    /**
     * @var string
     */
    protected static $route;

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatCountRouteDoesNotAllowNotSupportedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatCountRouteDoesNotAllowNotSupportedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . self::END_POINT_COUNT);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(405, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatCountRouteWorksWithAllowedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatCountRouteWorksWithAllowedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . self::END_POINT_COUNT);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(500, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatCountRouteDoesNotAllowInvalidUser
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatCountRouteDoesNotAllowInvalidUser(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . self::END_POINT_COUNT);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame($username === null ? 401 : 403, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatRootRouteDoesNotAllowNotSupportedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatRootRouteDoesNotAllowNotSupportedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(405, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatRootRouteWorksWithAllowedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatRootRouteWorksWithAllowedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(500, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatRootRouteDoesNotAllowInvalidUser
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatRootRouteDoesNotAllowInvalidUser(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame($username === null ? 401 : 403, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatRootRouteWithIdDoesNotAllowNotSupportedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatRootRouteWithIdDoesNotAllowNotSupportedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $uuid = Uuid::uuid4()->toString();

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . '/' . $uuid);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(405, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatRootRouteWithIdWorksWithAllowedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatRootRouteWithIdWorksWithAllowedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $uuid = Uuid::uuid4()->toString();

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . '/' . $uuid);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(500, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatRootRouteWithIdDoesNotAllowInvalidUser
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatRootRouteWithIdDoesNotAllowInvalidUser(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $uuid = Uuid::uuid4()->toString();

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . '/' . $uuid);

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame($username === null ? 401 : 403, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatIdsRouteDoesNotAllowNotSupportedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatIdsRouteDoesNotAllowNotSupportedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . '/ids');

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(405, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatIdsRouteWorksWithAllowedHttpMethods
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatIdsRouteWorksWithAllowedHttpMethods(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . '/ids');

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame(500, $response->getStatusCode(), $response->getContent());
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /**
     * @dataProvider dataProviderTestThatIdsRouteDoesNotAllowInvalidUser
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $method
     *
     * @throws \Exception
     */
    public function testThatIdsRouteDoesNotAllowInvalidUser(
        string $username = null,
        string $password = null,
        string $method = null
    ): void {
        $method = $method ?? 'GET';

        $client = $this->getClient($username, $password);
        $client->request($method, static::$route . '/ids');

        $response = $client->getResponse();

        static::assertInstanceOf(Response::class, $response);

        /** @noinspection NullPointerExceptionInspection */
        static::assertSame($username === null ? 401 : 403, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @return array
     */
    public function dataProviderTestThatCountRouteDoesNotAllowNotSupportedHttpMethods(): array
    {
        $methods = [
            ['HEAD'],
            ['POST'],
            ['PUT'],
            ['DELETE'],
            ['OPTIONS'],
            ['CONNECT'],
            ['foobar'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatCountRouteWorksWithAllowedHttpMethods(): array
    {
        $methods = [
            ['GET'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatCountRouteDoesNotAllowInvalidUser(): array
    {
        $methods = [
            ['GET'],
        ];

        return $this->createDataForTest($this->getInvalidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatRootRouteDoesNotAllowNotSupportedHttpMethods(): array
    {
        $methods = [
            ['PUT'],
            ['DELETE'],
            ['OPTIONS'],
            ['CONNECT'],
            ['foobar'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatRootRouteWorksWithAllowedHttpMethods(): array
    {
        $methods = [
            ['GET'],
            ['POST'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatRootRouteDoesNotAllowInvalidUser(): array
    {
        $methods = [
            ['GET'],
            ['POST'],
        ];

        return $this->createDataForTest($this->getInvalidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatRootRouteWithIdDoesNotAllowNotSupportedHttpMethods(): array
    {
        $methods = [
            ['POST'],
            ['OPTIONS'],
            ['CONNECT'],
            ['foobar'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatRootRouteWithIdWorksWithAllowedHttpMethods(): array
    {
        $methods = [
            ['DELETE'],
            ['GET'],
            ['PUT'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatRootRouteWithIdDoesNotAllowInvalidUser(): array
    {
        $methods = [
            ['DELETE'],
            ['GET'],
            ['PUT'],
        ];

        return $this->createDataForTest($this->getInvalidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatIdsRouteDoesNotAllowNotSupportedHttpMethods(): array
    {
        $methods = [
            ['POST'],
            ['PUT'],
            ['DELETE'],
            ['OPTIONS'],
            ['CONNECT'],
            ['foobar'],
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatIdsRouteWorksWithAllowedHttpMethods(): array
    {
        $methods = [
            ['GET']
        ];

        return $this->createDataForTest($this->getValidUsers(), $methods);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatIdsRouteDoesNotAllowInvalidUser(): array
    {
        $methods = [
            ['GET']
        ];

        return $this->createDataForTest($this->getInvalidUsers(), $methods);
    }

    /**
     * @param array $users
     * @param array $methods
     *
     * @return array
     */
    private function createDataForTest(array $users, array $methods): array
    {
        $output = [];

        foreach ($users as $userData) {
            foreach ($methods as $method) {
                $output[] = \array_merge($userData, $method);
            }
        }

        return $output;
    }
}
