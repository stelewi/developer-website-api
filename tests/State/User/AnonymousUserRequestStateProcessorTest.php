<?php

namespace App\Tests\State\User;

use ApiPlatform\Metadata\Post;
use App\Dto\AnonymousUserRequest;
use App\Entity\User;
use App\State\User\AnonymousUserRequestStateProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AnonymousUserRequestStateProcessorTest extends TestCase
{
    protected EntityManagerInterface $entityManager;

    protected UserPasswordHasherInterface $passwordHasher;

    protected JWTTokenManagerInterface $JWTTokenManager;

    protected AnonymousUserRequestStateProcessor $anonymousUserRequestStateProcessor;

    protected function setUp(): void
    {
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();

        $this->passwordHasher = $this->getMockBuilder(UserPasswordHasherInterface::class)
            ->getMock();

        $this->JWTTokenManager = $this->getMockBuilder(JWTTokenManagerInterface::class)
            ->getMock();

        $this->anonymousUserRequestStateProcessor = new AnonymousUserRequestStateProcessor(
            $this->entityManager,
            $this->passwordHasher,
            $this->JWTTokenManager
        );
    }

    public function testCreateAnonUser()
    {
        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(function($user) {

                return $user instanceof User &&
                    $user->getUsername() === 'testUserName';
            }));

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
            ->with($this->callback(function($user) {

                return $user instanceof User &&
                    $user->getUsername() === 'testUserName';
            }));

        $this->JWTTokenManager
            ->expects($this->once())
            ->method('create')
            ->with($this->callback(function($user) {

                return $user instanceof User &&
                    $user->getUsername() === 'testUserName';
            }))
            ->willReturn('DummyToken');

        $this->passwordHasher
            ->expects($this->once())
            ->method('hashPassword')
            ->with(
                $this->callback(function($user) {
                    return $user instanceof User &&
                            $user->getUsername() === 'testUserName';
                }),
                $this->callback(function($randomPassword) {
                    return is_string($randomPassword) && $randomPassword !== '';
                })
            )
            ->willReturn('DummyToken');

        $anonymousUserRequest = new AnonymousUserRequest();
        $anonymousUserRequest->setUsername('testUserName');

        $processedAnonymousUserRequest = $this->anonymousUserRequestStateProcessor->process(
            $anonymousUserRequest,
            new Post()
        );

        $this->assertInstanceOf(AnonymousUserRequest::class, $anonymousUserRequest);
        $this->assertEquals('testUserName', $processedAnonymousUserRequest->getUsername());
        $this->assertEquals('DummyToken', $processedAnonymousUserRequest->getJwtToken());
        $this->assertInstanceOf(User::class, $anonymousUserRequest->getNewAnonymousUser());
        $this->assertEquals('testUserName', $processedAnonymousUserRequest->getNewAnonymousUser()->getUsername());
        $this->assertNotEmpty($processedAnonymousUserRequest->getNewAnonymousUser()->getPassword());
    }
}
