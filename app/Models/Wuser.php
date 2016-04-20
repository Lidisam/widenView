<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Wuser",
 *      required={username},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="username",
 *          description="username",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="interlink",
 *          description="interlink",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="salt",
 *          description="salt",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Wuser extends Model
{
    use SoftDeletes;

    public $table = 'wusers';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'username',
        'password',
        'interlink',
        'salt'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'username' => 'string',
        'password' => 'string',
        'interlink' => 'string',
        'salt' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'username' => 'required|string'
    ];
}
