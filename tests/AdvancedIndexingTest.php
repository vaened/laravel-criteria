<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Criteria\Tests;

use Vaened\Criteria\Tests\Utils\PatientIndex;

final class AdvancedIndexingTest extends DataBaseTestCase
{
    public function test_filter_evaluates_the_index_and_determines_the_search_by_document_number(): void
    {
        $results = $this->searcher()->search(PatientIndex::Patient, '87654321')->get();

        $this->assertCount(1, $results);
    }

    public function test_filter_evaluates_the_index_and_determines_the_search_by_name(): void
    {
        $results = $this->searcher()->search(PatientIndex::Patient, 'Hana')->get();

        $this->assertCount(2, $results);
    }
}
