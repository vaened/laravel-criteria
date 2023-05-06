<?php
/**
 * Created by enea dhack - 07/06/2020 21:04.
 */

namespace Vaened\Criteria\Tests\Utils;

enum PatientIndex: string
{
    case Patient  = 'patient';

    case Document = 'Identification Document';

    case Name     = 'Full Name';
}
