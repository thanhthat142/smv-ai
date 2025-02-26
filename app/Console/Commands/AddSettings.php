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
        DB::table('settings')->truncate();
        foreach (Helpers::SETTING_FIELDS as $key => $type) {
            DB::table('settings')->insert([
                'key'         => $key,
                'name'        => $key,
                'description' => '',
                'value'       => '',
                'field'       => '{"name":"value","label":"Value","type":"'.$type.'"}', //text, textarea
                'active'      => 1,
            ]);

        }
        $this->line('Inserted '.count(Helpers::SETTING_FIELDS).' records.');
    }
}
