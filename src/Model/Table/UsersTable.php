<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\LikesTable&\Cake\ORM\Association\HasMany $Likes
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 * @property \App\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Likes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Notifications', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'sort' => ['Posts.created'=>'DESC'],
        ]);

        $this->belongsTo('Followers', [
            'foreignKey' => 'following_user',
        ]);

        $this->belongsTo('Followers', [
            'foreignKey' => 'follower_user',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('full_name')
            ->maxLength('full_name', 100)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->add('password',  [
                'required' => [
                  'rule' => array('custom','(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]*).{8,}$)'),
                  'message' => 'Password required atlest 1 capital letter, 1 special character and minimum of 8 characters long',
                ]
            ]);

        $validator
            ->sameAs('confirm_password', 'password', 'Password match failed');

        $validator
            ->requirePresence('age', 'create')
            ->notEmptyString('age');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 20)
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender');

          $validator
              ->boolean('verified')
              ->allowEmptyString('verified');

          $validator
              ->scalar('activation_token')
              ->maxLength('activation_token', 255)
              ->notEmptyString('activation_token');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->notEmptyString('profile_path')
            ->add('profile_path', [
              'extension' => [
                'rule' => ['extension', ['gif', 'png', 'jpg', 'jpeg']],
                'message' => 'Please upload only jpg, jpeg or png',
              ]
            ]);

          $validator
              ->notEmptyString('banner_path')
              ->add('banner_path', [
                'extension' => [
                  'rule' => ['extension', ['gif', 'png', 'jpg', 'jpeg']],
                  'message' => 'Please upload only jpg, jpeg or png',
                ]
              ]);

          $validator
              ->scalar('search')
              ->notEmptyString('search');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }

}
