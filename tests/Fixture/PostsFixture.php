<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostsFixture
 */
class PostsFixture extends TestFixture
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
                'image_path' => 'Lorem ipsum dolor sit amet',
                'post' => 'Lorem ipsum dolor sit amet',
                'shared_user_id' => 'Lorem ipsum dolor sit amet',
                'created' => '2022-01-28 09:04:36',
                'modified' => '2022-01-28 09:04:36',
                'deleted' => '2022-01-28 09:04:36',
            ],
        ];
        parent::init();
    }
}
