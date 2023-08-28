<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;


class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is your product name?');
        $description = $this->ask('What is your product description?');
        $price = $this->ask('How Much is your Product Worth?');
        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ], [
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:2'],
        ]);
        if ($validator->fails()) {
            $this->info('Product Not Created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        $productTemplate = $this->generateTemplate($name, $description, $price);

        if ($this->confirm(
            $productTemplate .
            'Do you confirm?',
            true
        )) {
            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price
            ]);
            $this->info('Product Created Successfully!!');
            $this->info($productTemplate);
        }
        return 1;
    }


    private function generateTemplate($name, $description, $price)
    {
        return 'Your Product Info: ' . PHP_EOL .
            '=============================================================' . PHP_EOL .
            '    Name    |       Description        |       Price ' . PHP_EOL .
            '=============================================================' . PHP_EOL .
            $name . '    |   ' . $description . '   |   ' . $price . PHP_EOL .
            '=============================================================' . PHP_EOL;
    }
}
