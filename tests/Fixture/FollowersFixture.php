<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FollowersFixture
 */
class FollowersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'following_user' => 1,
                'follower_user' => 1,
                'created' => '2022-02-07 07:11:20',
                'modified' => '2022-02-07 07:11:20',
                'deleted' => '2022-02-07 07:11:20',
            ],
        ];
        parent::init();
    }
}
