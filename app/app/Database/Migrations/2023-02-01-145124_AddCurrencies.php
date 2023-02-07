<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCurrencies extends Migration
{

  public function up()
  {
    $this->forge->createDatabase('currency_db', true);
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'auto_increment' => TRUE
      ],
      'currency_code' => [
        'type' => 'VARCHAR',
        'constraint' => '3',
        'null' => FALSE
      ],
      'created_at datetime default current_timestamp',
      'updated_at datetime default current_timestamp on update current_timestamp',
    ]);
    $this->forge->addKey('id', TRUE);
    $this->forge->createTable('currencies');
  }

  public function down()
  {
    $this->forge->dropTable('currencies');
  }
}
