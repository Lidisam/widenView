<?php

namespace App\Repositories;

use App\Models\Wuser;
use InfyOm\Generator\Common\BaseRepository;

class WuserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'password',
        'interlink'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Wuser::class;
    }
}
