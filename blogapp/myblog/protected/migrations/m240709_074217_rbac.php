<?php

class m240709_074217_rbac extends CDbMigration
{
    public function up()
    {

        // Create users table
        $this->createTable('users', array(
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'username' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'verification_token' => 'VARCHAR(255)',
            'verified' => 'TINYINT(1) DEFAULT 0',
        ));

        // Create posts table
        $this->createTable('posts', array(
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'INT NOT NULL',
            'title' => 'VARCHAR(255) NOT NULL',
            'content' => 'TEXT NOT NULL',
            'is_public' => 'TINYINT(1) DEFAULT 1',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));

        // Add foreign key for posts table
        $this->addForeignKey('fk_posts_user', 'posts', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Create likes table
        $this->createTable('likes', array(
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'INT NOT NULL',
            'post_id' => 'INT NOT NULL',
        ));

        // Add foreign keys for likes table
        $this->addForeignKey('fk_likes_user', 'likes', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_likes_post', 'likes', 'post_id', 'posts', 'id', 'CASCADE', 'CASCADE');
        // Generate password hash
        $password = 'admin'; // Replace with your desired password
        $passwordHash = CPasswordHelper::hashPassword($password);

        // Insert admin user into user table
        $this->insert('users', array(
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'verified' => '1',
            'password' => $passwordHash, // Replace with hashed password
        ));
    }

    public function down()
    {
        // Drop tables if exists in reverse order
        $this->dropIfExists('likes');
        $this->dropIfExists('posts');
        $this->dropIfExists('users');
    }

    /**
     * Drops a table if it exists.
     * @param string $tableName the name of the table to be dropped.
     * @throws CException
     */
    protected function dropIfExists($tableName)
    {
        if ($this->getDbConnection()->schema->getTable($tableName) !== null) {
            $this->dropTable($tableName);
        }
    }
}