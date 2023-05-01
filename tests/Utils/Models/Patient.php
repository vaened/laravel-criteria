<?php
/**
 * Created by enea dhack - 12/07/2020 21:45.
 */

namespace Vaened\Criteria\Tests\Utils\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Patient
 *
 * @package Vaened\Searcher\Tests\Utils\Models
 * @author enea dhack <enea.so@live.com>
 *
 * @property int id
 * @property string name
 * @property string document
 * @property string history
 * @property string observation
 * @property Carbon affiliated_at
 * @property Carbon deleted_at
 * @property Account account
 */
class Patient extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'document',
        'history',
        'observation',
        'affiliated_at',
        'deleted_at',
    ];

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }
}
