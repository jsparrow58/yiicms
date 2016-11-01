<?php

use yii\db\Migration;
use function Faker\unique;

class m161021_065427_create_tbl_hs_user extends Migration
{
	const TBL_ADMIN = '{{%admin}}'; // 后台管理员表
	const TBL_USER = '{{%user}}'; // 前台用户表
	const TBL_CATEGORY = '{{%category}}'; // 栏目表
	const TBL_POST = '{{%post}}'; // 博客表
	const TBL_STAT = '{{%status}}'; // 状态表
	const TBL_COMMENT = '{{%comment}}'; // 用户评论表
	const TBL_LOGIN = '{{%login}}'; // 用户登录表
	const TBL_ADMINLOGIN = '{{%admin_login}}'; // 管理员登录表
	const TBL_LOG = '{{%log}}'; // 日志表
	
    public function up()
	{
    	$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		
		// 后台管理员表
		$this->createTable(self::TBL_ADMIN, [
			'id' => 'upk',
			'email' => $this->string(255)->notNull()->unique()->comment('电子邮箱'),
			'auth_key' => $this->string(32)->notNull()->defaultValue('')->comment('auth_key'),
			'password_hash' => $this->string(255)->notNull()->defaultValue('')->comment('密码Hash'),
			'password_reset_token' => $this->string(255)->null()->unique()->comment('密码重置命牌'),
			'status' => $this->smallInteger(6)->unsigned()->notNull()->defaultValue(0)->comment('用户状态'),
			'created_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('建立日期'),
			'updated_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('更新日期'),
			'last_login_ip' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('最后登录地址'),
			'last_login_time' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('最后登录时间'),
		], $tableOptions);
		
		// 前台用户表
		$this->createTable(self::TBL_USER, [
			'id' => 'upk',
			'email' => $this->string(255)->notNull()->unique()->comment('电子邮箱'),
			'password' => $this->string(32)->notNull()->comment('密码'),
			'auth_key' => $this->string(32)->notNull()->defaultValue('')->comment('auth_key'),
			'password_hash' => $this->string(255)->notNull()->defaultValue('')->comment('密码Hash'),
			'password_reset_token' => $this->string(255)->null()->unique()->comment('密码重置命牌'),
			'created_at' => $this->integer(10)->unsigned()->comment('注册日期'),
			'u_id' => $this->integer(10)->unsigned()->defaultValue(0)->comment('更新用户，是admin表中的用户'),
			'updated_at' => $this->integer(10)->unsigned()->defaultValue(0)->comment('更新日期'),
			'last_login_ip' => $this->integer(10)->unsigned()->defaultValue(0)->comment('最后登录地址'),
			'last_login_time' => $this->integer(10)->unsigned()->defaultValue(0)->comment('最后登录时间'),
			'status' => $this->smallInteger(1)->defaultValue(0)->comment('用户状态'),
		], $tableOptions);

		// 栏目表
		$this->createTable(self::TBL_CATEGORY, [
			'id' => 'upk',
			'pid' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('父栏目'),
			'postion' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('排序'),
			'title' => $this->string()->notNull()->defaultValue('')->comment('标题'),
			'hide' => $this->boolean()->notNull()->defaultValue(false)->comment('是否隐藏'),
			'image' => $this->string()->notNull()->defaultValue('')->comment('图片'),
			'icon' => $this->string()->notNull()->defaultValue('')->comment('图标'),
			'status' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态'),
		], $tableOptions);
		//$this->addForeignKey('fk_category_pid_id', self::TBL_CATEGORY, 'pid', self::TBL_CATEGORY, 'id');
		
		// 博客文章表
		$this->createTable(self::TBL_POST, [
			'id' => 'upk',
			'category' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('所属栏目'),
			'title' => $this->string()->notNull()->defaultValue('')->comment('标题'),
			'content' => $this->text()->notNull()->defaultValue('')->comment('内容'),
			'tags' => $this->string(255)->notNull()->defaultValue('')->comment('标签'),
			'author_id' => $this->integer(10)->unsigned()->defaultValue(0)->comment('作者'),
			'created_at' => $this->integer(10)->unsigned()->defaultValue(0)->comment('发表日期'),
			'updated_id' => $this->integer(10)->unsigned()->defaultValue(0)->comment('更新用户'),
			'updated_at' => $this->integer(10)->unsigned()->defaultValue(0)->comment('更新日期'),
			'status' => $this->smallInteger(1)->defaultValue(0)->comment('博文状态'),
		], $tableOptions);
		$this->addForeignKey('fk_post_cid_category_id', self::TBL_POST, 'category', self::TBL_CATEGORY, 'id');
		$this->addForeignKey('fk_post_authorid_admin_id', self::TBL_POST, 'author_id', self::TBL_ADMIN, 'id');
		$this->addForeignKey('fk_post_updatedId_admin_id', self::TBL_POST, 'updated_id', self::TBL_ADMIN, 'id');
		
		// 博客评论表
		$this->createTable(self::TBL_COMMENT, [
			'id' => 'upk',
			'content' => $this->text()->notNull()->defaultValue('')->comment('评论内容'),
			'status' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)->comment('评论状态'),

			'postid' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('文章id'),

			'uid' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('用户id'),
			'email' => $this->string()->notNull()->defaultValue('')->comment('电子邮箱'),
			'client_ip' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('用户ip'),
			'client_time' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('发表时间'),
		], $tableOptions);
		$this->addForeignKey('fk_comment_postid_post_id', self::TBL_COMMENT, 'postid', self::TBL_POST, 'id');
		$this->addForeignKey('fk_comment_uid_user_id', self::TBL_COMMENT, 'uid', self::TBL_USER, 'id');
		
		// 用户登录日志表
		$this->createTable(self::TBL_LOGIN, [
			'id' => 'upk',
			'uid' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('用户id'),
			'client_ip' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('登陆地址'),
			'client_time' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('登陆时间'),
			'login_status' => $this->string()->notNull()->defaultValue('')->comment('登陆状态'),
		], $tableOptions);
		$this->addForeignKey('fk_login_uid_user_id', self::TBL_LOGIN, 'uid', self::TBL_USER, 'id');
		
		// 管理员登录日志表
		$this->createTable(self::TBL_ADMINLOGIN, [
			'id' => 'upk',
			'uid' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('用户id'),
			'client_ip' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('登陆地址'),
			'client_time' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('登陆时间'),
			'login_status' => $this->string()->notNull()->defaultValue('')->comment('登陆状态'),
		], $tableOptions);
		$this->addForeignKey('fk_adminlogin_uid_admin_id', self::TBL_ADMINLOGIN, 'uid', self::TBL_ADMIN, 'id');
		
		$this->createTable(self::TBL_LOG, [
			'id' => 'upk',
			'level' => $this->string(20)->notNull()->defaultValue('')->comment('日志级别'),
			'content' => $this->text()->notNull()->defaultValue('')->comment('日志内容'),
		], $tableOptions);
		// $this->addForeignKey($name, $table, $columns, $refTable, $refColumns);
    }

    public function down()
    {
        $this->dropTable(self::TBL_NAME);
		return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
