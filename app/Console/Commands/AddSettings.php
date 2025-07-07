<?php

namespace App\Console\Commands;

use App\Helpers;
use Backpack\Settings\app\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $totalInsert = 0;

        DB::table('settings')->truncate();
        foreach (Helpers::SETTING_FIELDS as $key => $type) {
            $typeSetting = '{"name":"value","label":"Value","type":"'.$type.'"}';
            if ($type == 'upload') {
                $typeSetting = '{"name":"value","label":"Value","type":"'.$type.'", "withFiles":{"disk":"uploads"}}';
            }
            if (DB::table('settings')->where('key', $key)->count() == 0) {
                DB::table('settings')->insert([
                    'key'         => $key,
                    'name'        => $key,
                    'description' => '',
                    'value'       => '',
                    'field'       => $typeSetting,
                    'active'      => 1,
                ]);
                $totalInsert++;
            }

        }
        $this->line('Inserted '.$totalInsert.' records.');
    }
}
