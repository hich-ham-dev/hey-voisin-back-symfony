<?php

namespace App\Tests\EventListener;

use App\Entity\User;
use App\EventListener\AuthenticationSuccessListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use PHPUnit\Framework\TestCase;

class AuthenticationSuccessListenerTest extends TestCase
{
    public function testOnAuthenticationSuccessResponseAddsUserData()
    {
        $user = $this->createMock(User::class);
        $user->method('getUserIdentifier')->willReturn('testuser');
        $user->method('getId')->willReturn(1);

        $event = $this->createMock(AuthenticationSuccessEvent::class);
        $event->method('getUser')->willReturn($user);
        $event->method('getData')->willReturn([]);
        $event->expects($this->once())->method('setData')->with($this->callback(function($data) {
            return isset($data['data']) && $data['data']['username'] === 'testuser' && $data['data']['id'] === 1;
        }));

        $listener = new AuthenticationSuccessListener();
        $listener->onAuthenticationSuccessResponse($event);
    }

    public function testOnAuthenticationSuccessResponseHandlesNonUserInterface()
    {
        $event = $this->createMock(AuthenticationSuccessEvent::class);
        $event->method('getUser')->willReturn(null);
        $event->expects($this->never())->method('setData');

        $listener = new AuthenticationSuccessListener();
        $listener->onAuthenticationSuccessResponse($event);
    }
}