<?php

namespace App\Console\Commands;

use App\Models\CryptoCurrency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FetchCryptoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crypto:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch top 50 cryptocurrencies from CoinGecko and update the database';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $this->info('Fetching data from CoinGecko...');

        $url = 'https://api.coingecko.com/api/v3/coins/markets';

        $response = Http::get($url, [
            'vs_currency' => 'usd',
            'order' => 'market_cap_desc',
            'per_page' => 50,
            'page' => 1,
            'sparkline' => 'true',
        ]);

        if ($response->failed()) {
            $this->error('Failed to fetch data.');
            return;
        }

        CryptoCurrency::truncate(); // Удаляем все старые записи

        foreach ($response->json() as $item) {
            CryptoCurrency::updateOrCreate(
                ['symbol' => strtoupper($item['symbol'])],
                [
                    'name' => $item['name'],
                    'price_usd' => $item['current_price'],
                    'change_24h' => $item['price_change_percentage_24h'],
                    'market_cap' => $item['market_cap'],
                    'volume_24h' => $item['total_volume'],
                    'sparkline' => $item['sparkline_in_7d']['price'],
                ]
            );
        }

        $this->info('Data successfully updated.');
    }
}
