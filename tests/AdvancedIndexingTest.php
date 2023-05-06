<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests;

use Vaened\Criteria\Tests\Utils\PatientIndex;

final class AdvancedIndexingTest extends DataBaseTestCase
{
    public function test_filter_eve(): void
    {
        $results = $this->searcher()->search(PatientIndex::Patient, '87654321')->get();

        $this->assertCount(1, $results);
    }

    public function test_filter_eve2(): void
    {
        $results = $this->searcher()->search(PatientIndex::Patient, 'Hana')->get();

        $this->assertCount(2, $results);
    }
}
