<?php
/**
 * Created by enea dhack - 13/07/2020 18:39.
 */

namespace Vaened\Criteria\Tests;

use DateTime;
use Vaened\Criteria\Tests\Utils\Models\Patient;
use Vaened\Criteria\Tests\Utils\OrderColumn;
use Vaened\CriteriaCore\Keyword\Order;

class SearcheableTest extends DataBaseTestCase
{
    public function test_filter_between_dates(): void
    {
        $results = $this->searcher()->affiliatedBetween(
            new DateTime('4001-01-02'),
            new DateTime('4001-01-03 23:59:59')
        )->get();

        $this->assertCount(2, $results);
    }

    public function test_load_accounts(): void
    {
        $result = $this->searcher()->loadAccounts()->get();

        $accounts = $result->map(
            fn(Patient $patient): bool => null !== $patient->getRelation('account')
        )->filter();

        $this->assertCount(1, $accounts);
    }

    public function test_unload_accounts(): void
    {
        $result   = $this->searcher()->loadAccounts()->unload('account')->get();
        $accounts = $result->map(fn(Patient $patient) => in_array('account', $patient->getRelations()))->filter();

        $this->assertCount(0, $accounts);
    }

    public function test_sort_descending_by_column(): void
    {
        $results = $this->searcher()->orderBy(Order::desc(OrderColumn::Affiliated->value))->get();
        $this->assertCount(3, $results);
    }

    public function test_search_by_observation(): void
    {
        $result = $this->searcher()->observationLikeTo('repeated');
        $this->assertCount(2, $result->get());
    }

    public function test_search_by_history(): void
    {
        $result = $this->searcher()->historyEqualsTo('0000003');
        $this->assertCount(1, $result->get());
    }

    public function test_search_different_document(): void
    {
        $result = $this->searcher()->documentNotEqualsTo('87654321');
        $this->assertCount(2, $result->get());
    }

    public function test_search_in_documents(): void
    {
        $result = $this->searcher()->inDocuments(['87654321', '12345678']);
        $this->assertCount(2, $result->get());
    }

    public function test_search_only_observed(): void
    {
        $result = $this->searcher()->onlyObserved();
        $this->assertCount(3, $result->get());
    }

    public function test_search_without_observation(): void
    {
        $result = $this->searcher()->withoutObservation();
        $this->assertCount(0, $result->get());
    }

    public function test_search_only_with_account(): void
    {
        $result = $this->searcher()->onlyWithAccount();
        $this->assertCount(1, $result->get());
    }

    public function test_limit_search(): void
    {
        $result = $this->searcher()->limit(2);
        $this->assertCount(2, $result->get());
    }

    public function test_search_by_observed_history(): void
    {
        $result = $this->searcher()->onlyObservedHistory('0000002');

        $this->assertCount(1, $result->get());
    }
}
