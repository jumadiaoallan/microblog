<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'username' => 'Lorem ipsum dolor sit amet',
                'full_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'age' => 1,
                'profile_path' => 'Lorem ipsum dolor sit amet',
                'banner_path' => 'Lorem ipsum dolor sit amet',
                'gender' => 'Lorem ipsum dolor ',
                'verified' => 1,
                'created' => '2022-01-25 06:11:42',
                'modified' => '2022-01-25 06:11:42',
                'deleted' => '2022-01-25 06:11:42',
            ],
        ];
        parent::init();
    }
}
