<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFollow extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('follows');
        $table->addColumn('followed_user_id', 'integer')
              ->addColumn('follower_user_id', 'integer')
              ->addColumn('created_at', 'datetime')
              ->addForeignKey('followed_user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->addForeignKey('follower_user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->create();
    }
}
