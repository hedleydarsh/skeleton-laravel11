<?php

namespace App\Constants;

class Constants
{
    // Permissions title
    const PERMISSIONS = [
        'user' => 'Usuários',
        'tournament' => 'Torneios',
        'category' => 'Categorias',
        'team' => 'Times',
        'permission' => 'Permissões',
        'role' => 'Perfis',
    ];

    const TOURNAMENT_STATUS = [
        'not_started' => 'Não iniciado',
        'started' => 'Iniciado',
        'finished' => 'Finalizado',
        'canceled' => 'Cancelado'
    ];

    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';
    const STATUS_CANCELED = 'canceled';

}
