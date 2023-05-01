<?php
/**
 * Created by enea dhack - 07/06/2020 20:11.
 */

namespace Vaened\Criteria\Tests\Utils;

/**
 * Class Indexes
 *
 * @package Tests\Unit\Components\Searcher\Utils
 * @author enea dhack <enea.so@live.com>
 *
 * @method static Filter Observed()
 * @method static Filter WithAccount()
 */
enum Filter: string
{
    case Observed    = 'Observed';

    case WithAccount = 'Only with account';
}
