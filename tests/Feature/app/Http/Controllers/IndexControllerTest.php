<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Member;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    /**
     * Vérifie que la page index retourne un code 200
     *
     * 2 Points
     */

    /**
     * Vérifie que la redirection est bien / après l'ajout d'un email
     * Doit retourner le message suivant index.success
     *
     * 2 Points
     */

    /**
     * Vérifie que l'ajout d'un email (john.doe@domain.tld) existant redirige vers /
     * Doit retourner les message suivant index.success
     * Il ne doit y avoir q'un email en base de donnée
     *
     * 2 Points
     */
    public function testIndex_AddMember_EmailAlreadyExistCase()
    {
        // Arrange
        $email = 'john.doe@domain.tld';

        factory(Member::class)->create([
            Member::EMAIL => $email
        ]);
        // Act
        // Assert
    }

    /**
     * Vérifie que l'ajout d'un email vide retourne une erreur 500
     *
     * 2 Points
     */
}
