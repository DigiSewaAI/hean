<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixInvoiceIdNotNull extends Command
{
    protected $signature = 'fix:invoice-id-not-null';
    protected $description = 'Fix invoice_id column to NOT NULL by dropping foreign key first';

    public function handle()
    {
        $this->info('Checking foreign key for payments.invoice_id...');

        $result = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'payments' 
            AND COLUMN_NAME = 'invoice_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (empty($result)) {
            $this->error('No foreign key found. Maybe already fixed?');
            return;
        }

        $fkName = $result[0]->CONSTRAINT_NAME;
        $this->info("Found foreign key: {$fkName}");

        $this->info('Dropping foreign key...');
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        DB::statement("ALTER TABLE payments DROP FOREIGN KEY {$fkName}");

        $this->info('Changing invoice_id to NOT NULL...');
        DB::statement("ALTER TABLE payments MODIFY invoice_id BIGINT UNSIGNED NOT NULL");

        $this->info('Re-adding foreign key with ON DELETE RESTRICT...');
        DB::statement("ALTER TABLE payments ADD CONSTRAINT {$fkName} FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE RESTRICT");

        DB::statement("SET FOREIGN_KEY_CHECKS=1");

        $this->info('✅ All done! invoice_id is now NOT NULL with correct foreign key.');
    }
}