<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $unit
 * @property string $street
 * @property string $city
 * @property string $province
 * @property string $country
 * @property integer $zip_code
 * @property string $phone_no
 * @property string $remember_token
 * @property string $email
 * @property string $password
 * @property string $birthday
 * @property string|null $profile_path
 * @property string|null $banner_path
 * @property string $gender
 * @property bool|null $verified
 * @property string $activation_token
 * @property \Cake\I18n\FrozenTime|null $generated_token
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Like[] $likes
 * @property \App\Model\Entity\Notification[] $notifications
 * @property \App\Model\Entity\Post[] $posts
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'unit' => true,
        'street' => true,
        'city' => true,
        'province' => true,
        'country' => true,
        'zip_code' => true,
        'phone_no' => true,
        'remember_token' => true,
        'password' => true,
        'birthday' => true,
        'profile_path' => true,
        'banner_path' => true,
        'gender' => true,
        'verified' => true,
        'activation_token' => true,
        'generated_token' => true,
        'created_at' => true,
        'updated_at' => true,
        'deleted' => true,
        'comments' => true,
        'likes' => true,
        'notifications' => true,
        'posts' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
