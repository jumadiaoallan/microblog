<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FollowersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FollowersTable Test Case
 */
class FollowersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FollowersTable
     */
    protected $Followers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Followers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Followers') ? [] : ['className' => FollowersTable::class];
        $this->Followers = $this->getTableLocator()->get('Followers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Followers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FollowersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\FollowersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
