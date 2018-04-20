<?php

namespace App\Services;

use App\Exceptions\EmailAlreadyExistException;
use App\Models\Member;

class MemberService
{
    /**
     * @var Member
     */
    private $member;

    public function __construct(Member $member)
    {

    }

    /**
     * Permet la création d'un nouvel email en base de donnée
     *
     * @param string $email
     * @throws EmailAlreadyExistException
     */
    public function create(string $email): void
    {

    }
}