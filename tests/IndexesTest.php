<?php
/**
 * Created by enea dhack - 15/06/2020 18:22.
 */

namespace Vaened\Criteria\Tests;

use Vaened\Criteria\Tests\Utils\{PatientIndex, Searcher};

class IndexesTest extends DataBaseTestCase
{
    public function test_search_by_name(): void
    {
        $results = $this->search(PatientIndex::Name, 'Hana')->get();
        $this->assertCount(2, $results);
    }

    public function test_search_by_document(): void
    {
        $results = $this->search(PatientIndex::Document, '87654321')->get();
        $this->assertCount(1, $results);
    }

    private function search(PatientIndex $index, string $q): Searcher
    {
        return $this->searcher()->search($index, $q);
    }
}
