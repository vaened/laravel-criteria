<?php
/**
 * Created by enea dhack - 12/07/2020 21:47.
 */

namespace Vaened\Criteria\Tests\Utils\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 *
 * @package Vaened\Searcher\Tests\Utils\Models
 * @author enea dhack <enea.so@live.com>
 *
 * @property int patient_id
 */
class Account extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'patient_id';

    protected $fillable = ['patient_id'];
}
