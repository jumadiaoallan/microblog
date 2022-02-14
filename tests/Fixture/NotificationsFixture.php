<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotificationsFixture
 */
class NotificationsFixture extends TestFixture
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
                'user_id' => 1,
                'notification' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'created' => '2022-02-08 08:34:36',
                'modified' => '2022-02-08 08:34:36',
                'deleted' => '2022-02-08 08:34:36',
            ],
        ];
        parent::init();
    }
}
