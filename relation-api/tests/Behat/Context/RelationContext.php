<?php
declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Relation\Infrastructure\Persistence\MongoDB\Document\RelationDocument;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class RelationContext implements Context
{
    private KernelInterface $kernel;
    private Response $response;

    public function __construct(KernelInterface $kernel) {
        $this->kernel = $kernel;
    }


    #[Given('I am a user')]
    public function iAmAUser(): void {
    }

    #[When('I create a new relation with the title :title')]
    public function iCreateANewRelationWithTheTitle(string $title): void {
        $request = Request::create(
            '/api/relations',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['title' => $title])
        );
        $this->response = $this->kernel->handle($request);
    }

    #[Then('the relation :title should exist in the system')]
    public function theRelationShouldExistInTheSystem(string $title): void {
        $relation = $this->fetchRelationByTitle($title);
        if (!$relation) {
            throw new \Exception(sprintf('Relation "%s" does not exist.', $title));
        }
    }

    #[Then('the status of the relation :title should be :status')]
    public function theStatusOfTheRelationShouldBe(string $title, string $status): void {
        $relation = $this->fetchRelationByTitle($title);
        if ($relation->getStatus() !== $status) {
            throw new \Exception(sprintf('Expected status "%s", got "%s".', $status, $relation['status']));
        }
    }


    #[Then('the response status code should be :statusCode')]
    public function theResponseStatusCodeShouldBe(int $statusCode): void {
        Assert::assertSame($statusCode, $this->response->getStatusCode(), "Expected status code $statusCode but got {$this->response->getStatusCode()}");
    }

    private function fetchRelationByTitle(string $title): ?RelationDocument {
        $repository = $this->kernel->getContainer()->get('doctrine_mongodb')->getRepository(RelationDocument::class);
        return $repository->findOneBy(['title' => $title]);
    }




}
