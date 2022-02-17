<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Followers Model
 *
 * @method \App\Model\Entity\Follower newEmptyEntity()
 * @method \App\Model\Entity\Follower newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Follower[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Follower get($primaryKey, $options = [])
 * @method \App\Model\Entity\Follower findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Follower patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Follower[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Follower|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Follower saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Follower[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Follower[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Follower[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Follower[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FollowersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
     use SoftDeleteTrait;

     protected $softDeleteField = 'deleted';
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('followers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Users', [
          'foreignKey' => 'id',
          'joinType' => 'INNER',
        ]);

        $this->hasMany('Users', [
          'foreignKey' => 'id',
          'joinType' => 'INNER',
        ]);

        $this->hasOne('Users', [
          'foreignKey' => 'id',
        ]);

        $this->hasOne('Posts', [
          'foreignKey' => 'user_id',
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->allowEmptyString('id', null, 'create');

        $validator
            ->requirePresence('following_user', 'create')
            ->notEmptyString('following_user');

        $validator
            ->requirePresence('follower_user', 'create')
            ->notEmptyString('follower_user');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        return $validator;
    }
}
