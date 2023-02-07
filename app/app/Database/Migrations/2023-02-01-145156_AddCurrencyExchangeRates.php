<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCurrencyExchangeRates extends Migration
{

  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'auto_increment' => TRUE
      ],
      'date' => [
        'type' => 'DATE',
        'null' => FALSE
      ],
      'currency_code' => [
        'type' => 'VARCHAR',
        'constraint' => '3',
        'null' => FALSE
      ],
      'rate' => [
        'type' => 'DECIMAL',
        'constraint' => '10,5',
        'null' => FALSE
      ],
      'created_at datetime default current_timestamp',
      'updated_at datetime default current_timestamp on update current_timestamp',
    ]);
    $this->forge->addKey('id', TRUE);
    $this->forge->addKey('currency_code');
    $this->forge->addUniqueKey(['currency_code', 'date'], 'currency_code_date_unique_key');
    $this->forge->createTable('currency_rates');
  }

  public function down()
  {
    $this->forge->dropTable('currency_rates');
  }
}
