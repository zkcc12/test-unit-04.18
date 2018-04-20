<?php

namespace App\Services;

use App\Exceptions\EmailAlreadyExistException;
use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class MemberService
{
    /**
     * @var Member
     */
    private $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Permet la récupération des emails de la TODO
     *
     * @return Collection
     * @throws \Exception
     */
    public function lists(): Collection
    {
        return $this->member->all();
    }

    /**
     * Permet la création d'un nouvel email en base de donnée
     *
     * @param string $email
     * @throws EmailAlreadyExistException
     */
    public function create(string $email): void
    {
        // $memberMocked
        $result = $this->member->where([
            Member::EMAIL => $email
        ])->first();

        if (!is_null($result)) {
            throw new EmailAlreadyExistException();
        }

        $this->member->create([
            Member::EMAIL => $email
        ]);

    }
}
