<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Models\Member;
use App\Services\MemberService;
use App\Exceptions\EmailAlreadyExistException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberServiceTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $memberMocked;

    /**
     * La méthode "setUp" est appelée à chaque excecution de test
     */
    public function setUp()
    {
        parent::setUp();

        $this->memberMocked = \Mockery::mock(Member::class);
    }

    /**
     * Doit ajouter un nouvel email en base de donnée
     * Doit aussi vérifier qu'un email est en cours d'envoi dans le gestionnaire de queue
     *
     * 2 Points
     */

     public function testAddMail_Success_NominalCase()
    {
        // Arrange
        $mail = 'test@gmail.com';

        // Assert
        $this->memberMocked->shouldReceive('where')
            ->once()
            ->with([
                Member::EMAIL => $mail
            ])
            ->andReturn($this->memberMocked);

        $this->memberMocked->shouldReceive('first')
            ->once()
            ->andReturnNull();


        $this->memberMocked->shouldReceive('create')
            ->once()
            ->with([
                Member::EMAIL => $mail
            ])
            ->andReturnTrue();

        $memberService = new MemberService($this->memberMocked);

        // Act
        $memberService->create($mail);
    }

    /**
     * Doit retourner une exception de type EmailAlreadyExistException
     * si l'email est déjà existant
     *
     * 2 Points
     */
    public function testAddMail_ExpectException_ExceptionCase()
    {
        // Arrange
        $mail = 'test@gmail.com';

        // SELECT email FROM member WHERE email = 'test@gmail.com' LIMIT 1;
        $this->memberMocked->shouldReceive('where')
            ->once()
            ->with([
                Member::EMAIL => $mail
            ])
            ->andReturn($this->memberMocked);

        $this->memberMocked->shouldReceive('first')
            ->once()
            ->andReturn(new Member());

        $this->memberMocked->shouldReceive('create')
            ->times(0);

        $MemberService = new MemberService($this->memberMocked);

        // Assert
        $this->expectException(EmailAlreadyExistException::class);

        // Act
        $MemberService->create($mail);
    }
}
